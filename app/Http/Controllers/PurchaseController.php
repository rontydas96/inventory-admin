<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));

        $purchases = Purchase::with('products')
            ->when($search, function ($query) use ($search) {
                $query->where('purchase_invoice_no', 'like', "%{$search}%")
                    ->orWhereHas('products', function ($productQuery) use ($search) {
                        $productQuery->where('material_code', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('purchases.index', compact('purchases', 'search'));
    }

    public function create()
    {
        return view('purchases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_invoice_no' => ['required', 'string', 'max:255'],
            'purchase_invoice_pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $filePath = $request->file('purchase_invoice_pdf')->store('purchase_invoices');

        Purchase::create([
            'purchase_invoice_no' => $validated['purchase_invoice_no'],
            'purchase_invoice_pdf' => $filePath,
        ]);

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase invoice uploaded successfully.');
    }

    public function edit(Purchase $purchase)
    {
        return view('purchases.edit', compact('purchase'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'purchase_invoice_no' => ['required', 'string', 'max:255'],
            'purchase_invoice_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $oldInvoice = $purchase->purchase_invoice_no;
        $newInvoice = $validated['purchase_invoice_no'];

        if ($request->hasFile('purchase_invoice_pdf')) {
            if (Storage::exists($purchase->purchase_invoice_pdf)) {
                Storage::delete($purchase->purchase_invoice_pdf);
            }
            $purchase->purchase_invoice_pdf = $request->file('purchase_invoice_pdf')->store('purchase_invoices');
        }

        $purchase->purchase_invoice_no = $newInvoice;
        $purchase->save();

        if ($oldInvoice !== $newInvoice) {
            $remaining = Purchase::where('purchase_invoice_no', $oldInvoice)
                ->where('id', '!=', $purchase->id)
                ->count();

            if ($remaining === 0) {
                Product::where('purchase_invoice_no', $oldInvoice)
                    ->update(['purchase_invoice_no' => $newInvoice]);
            }
        }

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase invoice updated successfully.');
    }

    public function destroy(Purchase $purchase)
    {
        $invoice = $purchase->purchase_invoice_no;

        if (Storage::exists($purchase->purchase_invoice_pdf)) {
            Storage::delete($purchase->purchase_invoice_pdf);
        }

        $purchase->delete();

        $remaining = Purchase::where('purchase_invoice_no', $invoice)->count();
        if ($remaining === 0) {
            Product::where('purchase_invoice_no', $invoice)
                ->update(['purchase_invoice_no' => null]);
        }

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase invoice deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $invoiceNumbers = Purchase::query()
            ->where('purchase_invoice_no', 'like', "%{$query}%")
            ->distinct()
            ->orderBy('purchase_invoice_no')
            ->limit(20)
            ->pluck('purchase_invoice_no');

        return response()->json($invoiceNumbers);
    }

    public function productSearch(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->where(function ($qBuilder) use ($query) {
                $qBuilder->where('material_code', 'like', "%{$query}%")
                    ->orWhere('name', 'like', "%{$query}%");
            })
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'material_code', 'name']);

        return response()->json($products);
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('products');

        return view('purchases.show', compact('purchase'));
    }

    public function download(Purchase $purchase)
    {
        if (!Storage::exists($purchase->purchase_invoice_pdf)) {
            return redirect()
                ->route('purchases.index')
                ->with('error', 'Invoice PDF not found.');
        }

        return Storage::download($purchase->purchase_invoice_pdf, $purchase->purchase_invoice_no . '.pdf');
    }
}
