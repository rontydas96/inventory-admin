@extends('layouts.app')

@section('title', 'Add Product')

@section('styles')
<style>
    .search-results { background: #fff; border: 1px solid var(--border); border-radius: 8px; max-height: 220px; overflow-y: auto; margin-top: -8px; position: relative; z-index: 10; }
    .search-item { padding: 10px 14px; cursor: pointer; border-bottom: 1px solid var(--border); font-size: 14px; }
    .search-item:last-child { border-bottom: none; }
    .search-item:hover { background: #f1f5f9; }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-plus-circle"></i> Add Product</h1>
        <a href="{{ route('products.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Products</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('products.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Material No</label>
                <input type="text" name="material_code" class="form-control" value="{{ old('material_code') }}" required>
            </div>
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>HSN Code</label>
                <input type="text" name="hsn_code" class="form-control" value="{{ old('hsn_code') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Purchase Invoice</label>
                <input type="text" name="purchase_invoice_no" id="purchaseInvoiceNo" class="form-control" value="{{ old('purchase_invoice_no') }}" autocomplete="off">
                <div id="invoiceSearchResults" class="search-results" style="display: none;"></div>
            </div>
            <div class="form-group">
                <label>Purchase Invoice Date</label>
                <input type="date" name="purchase_invoice_date" id="purchaseInvoiceDate" class="form-control" value="{{ old('purchase_invoice_date') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Main Category</label>
                <input type="text" name="main_category" class="form-control" value="{{ old('main_category') }}">
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>
            <div class="form-group">
                <label>Selling Price</label>
                <input type="number" step="0.01" min="0" name="selling_price" class="form-control" value="{{ old('selling_price') }}">
            </div>
            <div class="form-group">
                <label>Stock Level</label>
                <input type="number" min="0" name="stock_level" class="form-control" value="{{ old('stock_level') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>GST %</label>
                <input type="number" step="0.01" min="0" max="100" name="gst_percentage" class="form-control" value="{{ old('gst_percentage') }}">
            </div>
            <div class="form-group">
                <label>Rating</label>
                <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="{{ old('rating') }}">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Active" @selected(old('status') === 'Active')>Active</option>
                    <option value="Out of Stock" @selected(old('status') === 'Out of Stock')>Out of Stock</option>
                    <option value="Discontinued" @selected(old('status') === 'Discontinued')>Discontinued</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" value="{{ old('unit') }}">
            </div>
        </div>

        <div class="form-group">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control" rows="3">{{ old('remarks') }}</textarea>
        </div>

        <button type="submit" class="btn" style="margin-top:8px;"><i class="fas fa-save"></i> Save Product</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const purchaseInvoiceNoInput = document.getElementById('purchaseInvoiceNo');
    const invoiceSearchResults = document.getElementById('invoiceSearchResults');
    purchaseInvoiceNoInput.addEventListener('input', async function () {
        const q = this.value.trim();
        if (q.length < 2) { invoiceSearchResults.innerHTML = ''; invoiceSearchResults.style.display = 'none'; return; }
        const response = await fetch(`{{ route('purchases.search') }}?q=${encodeURIComponent(q)}`);
        const invoices = await response.json();
        invoiceSearchResults.innerHTML = '';
        if (invoices.length === 0) { invoiceSearchResults.style.display = 'none'; return; }
        invoices.forEach(invoice => {
            const div = document.createElement('div');
            div.className = 'search-item';
            div.textContent = invoice;
            div.onclick = () => { purchaseInvoiceNoInput.value = invoice; invoiceSearchResults.innerHTML = ''; invoiceSearchResults.style.display = 'none'; };
            invoiceSearchResults.appendChild(div);
        });
        invoiceSearchResults.style.display = 'block';
    });
    document.addEventListener('click', function (event) {
        if (!invoiceSearchResults.contains(event.target) && event.target !== purchaseInvoiceNoInput) {
            invoiceSearchResults.innerHTML = '';
            invoiceSearchResults.style.display = 'none';
        }
    });
</script>
@endsection