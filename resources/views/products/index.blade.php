@extends('layouts.app')

@section('title', 'Products')

@section('styles')
<style>
    .column-panel { background: #f8fafc; border: 1px solid var(--border); border-radius: 12px; padding: 18px 20px; }
    .column-panel-header { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
    .column-panel-header h2 { font-size: 15px; font-weight: 600; }
    .column-panel-header p { font-size: 13px; color: var(--text-muted); }
    .checkbox-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 8px; }
    .checkbox-grid label { display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 8px; background: #fff; border: 1px solid var(--border); font-size: 13px; cursor: pointer; transition: all .15s ease; }
    .checkbox-grid label:hover { background: #eef2ff; border-color: #c7d2fe; }
    .checkbox-grid input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--primary); }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-box"></i> Products</h1>
        <div class="btn-group" style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Dashboard</a>
            <a href="{{ route('products.upload') }}" class="btn btn-accent"><i class="fas fa-upload"></i> Upload Excel</a>
            <a href="{{ route('products.exportCsv') }}" class="btn btn-success"><i class="fas fa-download"></i> CSV</a>
            <a href="{{ route('products.create') }}" class="btn"><i class="fas fa-plus"></i> Add Product</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Search by Material No or name" value="{{ $search }}">
        <button class="btn" type="submit"><i class="fas fa-search"></i> Search</button>
    </form>

    <div class="controls" style="margin-bottom:20px;">
        <div class="column-panel">
            <div class="column-panel-header">
                <i class="fas fa-eye" style="color: var(--text-muted);"></i>
                <div>
                    <h2>Column Visibility</h2>
                    <p>Show or hide fields in the product list.</p>
                </div>
            </div>
            <div class="checkbox-grid">
                <label><input class="column-toggle" type="checkbox" value="material_code" checked><i class="fas fa-hashtag" style="color:var(--text-muted);font-size:12px;"></i> Material No</label>
                <label><input class="column-toggle" type="checkbox" value="name" checked><i class="fas fa-tag" style="color:var(--text-muted);font-size:12px;"></i> Name</label>
                <label><input class="column-toggle" type="checkbox" value="hsn_code" checked>HSN Code</label>
                <label><input class="column-toggle" type="checkbox" value="main_category" checked><i class="fas fa-folder" style="color:var(--text-muted);font-size:12px;"></i> Main Category</label>
                <label><input class="column-toggle" type="checkbox" value="sub_category" checked>Sub Category</label>
                <label><input class="column-toggle" type="checkbox" value="remarks" checked>Remarks</label>
                <label><input class="column-toggle" type="checkbox" value="brand" checked><i class="fas fa-trademark" style="color:var(--text-muted);font-size:12px;"></i> Brand</label>
                <label><input class="column-toggle" type="checkbox" value="unit" checked>Unit</label>
                <label><input class="column-toggle" type="checkbox" value="gst" checked>GST %</label>
                <label><input class="column-toggle" type="checkbox" value="selling_price" checked>Selling Price</label>
                <label><input class="column-toggle" type="checkbox" value="price" checked>Price</label>
                <label><input class="column-toggle" type="checkbox" value="stock" checked><i class="fas fa-cubes" style="color:var(--text-muted);font-size:12px;"></i> Quantity</label>
                <label><input class="column-toggle" type="checkbox" value="rating" checked><i class="fas fa-star" style="color:var(--text-muted);font-size:12px;"></i> Rating</label>
                <label><input class="column-toggle" type="checkbox" value="status" checked>Status</label>
                <label><input class="column-toggle" type="checkbox" value="action" checked>Action</label>
            </div>
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th data-col="material_code">Material No</th>
                    <th data-col="name">Name</th>
                    <th data-col="hsn_code">HSN Code</th>
                    <th data-col="main_category">Main Category</th>
                    <th data-col="sub_category">Sub Category</th>
                    <th data-col="remarks">Remarks</th>
                    <th data-col="brand">Brand</th>
                    <th data-col="unit">Unit</th>
                    <th data-col="gst">GST %</th>
                    <th data-col="selling_price">Selling Price</th>
                    <th data-col="price">Price</th>
                    <th data-col="stock">Quantity</th>
                    <th data-col="rating">Rating</th>
                    <th data-col="status">Status</th>
                    <th data-col="action" width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td data-col="material_code"><strong>{{ $product->material_code }}</strong></td>
                        <td data-col="name">{{ $product->name }}</td>
                        <td data-col="hsn_code">{{ $product->hsn_code }}</td>
                        <td data-col="main_category">{{ $product->main_category }}</td>
                        <td data-col="sub_category">{{ $product->category }}</td>
                        <td data-col="remarks">{{ \Illuminate\Support\Str::limit($product->remarks, 50) }}</td>
                        <td data-col="brand">{{ $product->brand }}</td>
                        <td data-col="unit">{{ $product->unit }}</td>
                        <td data-col="gst">{{ number_format($product->gst_percentage ?? 0, 2) }}%</td>
                        <td data-col="selling_price">₹{{ number_format($product->selling_price ?? $product->price, 2) }}</td>
                        <td data-col="price">₹{{ number_format($product->price, 2) }}</td>
                        <td data-col="stock">{{ $product->stock_level }}</td>
                        <td data-col="rating">
                            @if($product->rating)
                                <span style="color:#f59e0b;">{{ str_repeat('★', min(5, (int)$product->rating)) }}</span>
                                <span style="color:var(--text-muted);font-size:12px;">{{ number_format($product->rating, 1) }}</span>
                            @endif
                        </td>
                        <td data-col="status">
                            @php
                                $status = $product->status;
                                $badgeClass = 'badge-gray';
                                if ($status === 'Active') $badgeClass = 'badge-success';
                                elseif ($status === 'Out of Stock') $badgeClass = 'badge-danger';
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                @if($status === 'Active')<i class="fas fa-check-circle"></i>
                                @elseif($status === 'Out of Stock')<i class="fas fa-times-circle"></i>
                                @endif
                                {{ $status }}
                            </span>
                        </td>
                        <td data-col="action">
                            <a class="btn btn-sm btn-accent" href="{{ route('products.edit', $product) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <p>No products found.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const storageKey = 'productColumnVisibility';
        const saved = JSON.parse(localStorage.getItem(storageKey) || '{}');
        const toggles = document.querySelectorAll('.column-toggle');
        const headerCells = Array.from(document.querySelectorAll('th[data-col]'));

        function updateColumn(columnKey, visible) {
            const index = headerCells.findIndex((th) => th.dataset.col === columnKey);
            if (index === -1) return;
            const rows = document.querySelectorAll('table tr');
            rows.forEach((row) => {
                const cell = row.cells[index];
                if (cell) cell.style.display = visible ? '' : 'none';
            });
        }

        function savePreferences() {
            localStorage.setItem(storageKey, JSON.stringify(saved));
        }

        toggles.forEach((toggle) => {
            const columnKey = toggle.value;
            const visible = saved[columnKey] !== false;
            toggle.checked = visible;
            updateColumn(columnKey, visible);
            toggle.addEventListener('change', function () {
                saved[columnKey] = this.checked;
                updateColumn(columnKey, this.checked);
                savePreferences();
            });
        });
    });
</script>
@endsection