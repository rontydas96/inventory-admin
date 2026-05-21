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
                $query->where('product_id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'string', 'max:255', 'unique:products,product_id,' . $product->id],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_level' => ['required', 'integer', 'min:0'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'status' => ['required', 'in:Active,Out of Stock,Discontinued'],
            'main_category' => ['nullable', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:50'],
            'applied_gst' => ['nullable', 'numeric', 'min:0', 'max:100'],

        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }
}