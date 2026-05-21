<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    /**
     * Show the New Sale page.
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * AJAX product search by SKU (product_id) or product name.
     */
    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->where('status', 'Active')
            ->where('stock_level', '>', 0)
            ->where(function ($qBuilder) use ($query) {
                $qBuilder->where('product_id', 'like', "%{$query}%")
                    ->orWhere('name', 'like', "%{$query}%");
            })
            ->orderBy('name')
            ->limit(20)
            ->get([
                'id',
                'product_id',
                'name',
                'price',
                'stock_level',
                'brand',
            ]);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_gst' => ['nullable', 'string', 'max:50'],
            'customer_pan' => ['nullable', 'string', 'max:50'],
            'billing_address' => ['nullable', 'string'],
            'shipping_address' => ['nullable', 'string'],
            'cart_data' => ['required', 'string'],
            'po_no' => ['nullable', 'string', 'max:255'],
            'challan_no' => ['nullable', 'string', 'max:255'],
            'vehicle_no' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string'],
        ]);

        $cart = json_decode($request->cart_data, true);

        if (!is_array($cart) || count($cart) === 0) {
            return back()
                ->withErrors(['cart_data' => 'Cart is empty.'])
                ->withInput();
        }

        $sale = DB::transaction(function () use ($request, $cart) {

            $setting = Setting::first();

            $subtotal = 0;   // Taxable total
            $gstAmount = 0;  // Total GST

            /*
            |--------------------------------------------------------------------------
            | First Loop: Validate Stock & Calculate Totals
            |--------------------------------------------------------------------------
            */
            foreach ($cart as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['id']);

                $quantity = (int) $item['quantity'];

                if ($quantity < 1) {
                    throw new \Exception("Invalid quantity for {$product->name}");
                }

                if ($product->stock_level < $quantity) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                // Price from CSV is GST-inclusive
                $inclusivePrice = (float) $product->price;

                // Product-specific GST or default GST
                $gstPercent = (float) (
                    $product->applied_gst
                    ?? $setting->default_gst_percentage
                    ?? 18
                );

                // GST included in one unit price
                $gstPerUnit = $inclusivePrice * $gstPercent / (100 + $gstPercent);

                // Taxable unit price
                $basePrice = $inclusivePrice - $gstPerUnit;

                // Line totals
                $lineSubtotal = round($basePrice * $quantity, 2);
                $lineGst = round($gstPerUnit * $quantity, 2);

                $subtotal += $lineSubtotal;
                $gstAmount += $lineGst;
            }

            // Final grand total (same as inclusive prices total)
            $grandTotal = round($subtotal + $gstAmount, 2);

            /*
            |--------------------------------------------------------------------------
            | Create Sale
            |--------------------------------------------------------------------------
            */
            $invoiceNo = 'INV-' . now()->format('Ymd-His') . '-' . strtoupper(Str::random(4));

            $sale = Sale::create([
                'invoice_no' => $invoiceNo,
                'customer_name' => $request->customer_name,
                'billing_address' => $request->billing_address,
                'shipping_address' => $request->shipping_address,
                'customer_gst' => $request->customer_gst,
                'customer_pan' => $request->customer_pan,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'subtotal' => round($subtotal, 2),
                'gst_amount' => round($gstAmount, 2),
                'grand_total' => round($grandTotal, 2),
                'po_no' => $request->po_no,
                'challan_no' => $request->challan_no,
                'vehicle_no' => $request->vehicle_no,
                'subject' => $request->subject,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Second Loop: Create Sale Items & Deduct Stock
            |--------------------------------------------------------------------------
            */
            foreach ($cart as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['id']);

                $quantity = (int) $item['quantity'];

                // Inclusive price from CSV
                $inclusivePrice = (float) $product->price;

                // GST %
                $gstPercent = (float) (
                    $product->applied_gst
                    ?? $setting->default_gst_percentage
                    ?? 18
                );

                // GST per unit
                $gstPerUnit = $inclusivePrice * $gstPercent / (100 + $gstPercent);

                // Taxable price per unit
                $basePrice = $inclusivePrice - $gstPerUnit;

                // Line totals
                $lineSubtotal = round($basePrice * $quantity, 2);
                $lineGst = round($gstPerUnit * $quantity, 2);
                $lineTotal = round($inclusivePrice * $quantity, 2);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'sku' => $product->product_id,
                    'product_name' => $product->name,

                    // Taxable unit price (without GST)
                    'unit_price' => round($basePrice, 2),

                    'quantity' => $quantity,
                    'gst_percentage' => round($gstPercent, 2),
                    'gst_amount' => round($lineGst, 2),

                    // Final GST-inclusive total
                    'line_total' => round($lineTotal, 2),
                ]);

                // Reduce stock
                $product->decrement('stock_level', $quantity);
            }

            return $sale;
        });

        // Load relationships
        // $sale->load('items.product');

        // $setting = Setting::first();

        // // Generate PDF
        // $pdf = Pdf::loadView('invoices.pdf', [
        //     'sale' => $sale,
        //     'setting' => $setting,
        // ]);

        // return $pdf->download($sale->invoice_no . '.pdf');
        $sale->load('items.product');

        return redirect()
            ->route('sales.success', $sale->id)
            ->with('success', 'Sale completed successfully.');
    }

    public function success(Sale $sale)
    {
        $sale->load('items.product');

        $setting = Setting::first();

        return view('sales.success', compact('sale', 'setting'));
    }

    public function downloadPdf(Sale $sale)
    {
        $sale->load('items.product');

        $setting = Setting::first();

        $pdf = Pdf::loadView('invoices.pdf', [
            'sale' => $sale,
            'setting' => $setting,
        ]);

        return $pdf->download($sale->invoice_no . '.pdf');
    }

    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));

        $sales = Sale::query()
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_no', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('sales.index', compact('sales', 'search'));
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product');
        return view('sales.show', compact('sale'));
    }

    public function download(Sale $sale)
    {
        $sale->load('items.product');
        $setting = Setting::first();

        $pdf = Pdf::loadView('invoices.pdf', [
            'sale' => $sale,
            'setting' => $setting,
        ]);

        return $pdf->download($sale->invoice_no . '.pdf');
    }
}