<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;

class ProductController extends Controller
{
    public function uploadForm()
    {
        return view('products.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240', // 10 MB
            ],
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return redirect()
            ->route('products.upload')
            ->with('success', 'Products imported successfully.');
    }

    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));

        $products = Product::query()
            ->when($search, function ($query) use ($search) {
                $query->where('material_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_code' => ['required', 'string', 'max:255', 'unique:products,material_code'],
            'name' => ['required', 'string', 'max:255'],
            'hsn_code' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_level' => ['required', 'integer', 'min:0'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'status' => ['required', 'in:Active,Out of Stock,Discontinued'],
            'main_category' => ['nullable', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:50'],
            'gst_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'purchase_invoice_no' => ['nullable', 'string', 'max:255'],
            'purchase_invoice_date' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'material_code' => ['required', 'string', 'max:255', 'unique:products,material_code,' . $product->id],
            'name' => ['required', 'string', 'max:255'],
            'hsn_code' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_level' => ['required', 'integer', 'min:0'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'status' => ['required', 'in:Active,Out of Stock,Discontinued'],
            'main_category' => ['nullable', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:50'],
            'gst_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'purchase_invoice_no' => ['nullable', 'string', 'max:255'],
            'purchase_invoice_date' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string', 'max:1000'],

        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function exportCsv()
    {
        $filename = 'product_upload_format_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                '',
            ]);

            fputcsv($handle, [
                'material_code',
                'description_of_material',
                'hsn_code',
                'main_category',
                'sub_category',
                'unit',
                'gst_percentage',
                'costin_rs_inclusive_of_gst',
                'selling_price',
                'available_quantity',
                'purchase_invoice_date',
                'remarks',
            ]);

            Product::orderBy('name')->chunk(200, function ($products) use ($handle) {
                foreach ($products as $product) {
                    fputcsv($handle, [
                        $product->material_code,
                        $product->name,
                        $product->hsn_code,
                        $product->main_category,
                        $product->category,
                        $product->unit,
                        $product->gst_percentage,
                        $product->price,
                        $product->selling_price,
                        $product->stock_level,
                        optional($product->purchase_invoice_date)->format('Y-m-d'),
                        $product->remarks,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}