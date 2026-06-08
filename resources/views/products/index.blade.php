<!DOCTYPE html>
<html>

<head>
  <title>Products</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8fafc;
      padding: 40px;
    }

    .card {
      max-width: 1300px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
    }

    input[type="text"] {
      padding: 10px;
      width: 300px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
    }

    .btn {
      padding: 10px 16px;
      background: #0f172a;
      color: #fff;
      border-radius: 6px;
      text-decoration: none;
      display: inline-block;
      border: none;
      cursor: pointer;
    }

    .controls {
      margin-top: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      align-items: flex-start;
    }

    .column-panel {
      flex: 1 1 100%;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 18px 20px;
      display: grid;
      grid-template-columns: minmax(220px, 260px) 1fr;
      gap: 18px;
    }

    .column-panel h2 {
      margin: 0 0 8px;
      font-size: 16px;
      color: #111827;
    }

    .column-panel p {
      margin: 0;
      color: #4b5563;
      font-size: 14px;
      line-height: 1.5;
    }

    .checkbox-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 10px;
    }

    .checkbox-grid label {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 10px;
      background: #fff;
      border: 1px solid #d1d5db;
      font-size: 14px;
      color: #111827;
      cursor: pointer;
      transition: background .2s ease, border-color .2s ease;
    }

    .checkbox-grid label:hover {
      background: #eef2ff;
      border-color: #c7d2fe;
    }

    .checkbox-grid input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: #0f172a;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #e5e7eb;
      padding: 10px;
      text-align: left;
    }

    th {
      background: #f1f5f9;
    }

    .badge {
      padding: 4px 8px;
      border-radius: 999px;
      font-size: 12px;
      background: #e5e7eb;
    }

    .pagination {
      margin-top: 20px;
    }

    h1 {
      margin-top: 0;
    }
  </style>
</head>

<body>
  <div class="card">
    <h1>Products</h1>

    <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
    <a href="{{ route('products.upload') }}" class="btn">Upload Excel</a>
    <a href="{{ route('products.exportCsv') }}" class="btn">Download CSV</a>
    <a href="{{ route('products.create') }}" class="btn">Add Product</a>

    @if(session('success'))
      <p style="color: green; margin-top: 20px;">
        {{ session('success') }}
      </p>
    @endif

    <form method="GET" style="margin-top: 20px; display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
      <input type="text" name="search" placeholder="Search by Material No or name" value="{{ $search }}">
      <button class="btn" type="submit">Search</button>
    </form>

    <div class="controls">
      <div class="column-panel">
        <div>
          <h2>Column visibility</h2>
          <p>Show or hide fields in the product list without changing other functionality.</p>
        </div>
        <div class="checkbox-grid">
          <label><input class="column-toggle" type="checkbox" value="material_code" checked>Material No</label>
          <label><input class="column-toggle" type="checkbox" value="name" checked>Name</label>
          <label><input class="column-toggle" type="checkbox" value="hsn_code" checked>HSN Code</label>
          <label><input class="column-toggle" type="checkbox" value="main_category" checked>Main Category</label>
          <label><input class="column-toggle" type="checkbox" value="sub_category" checked>Sub Category</label>
          <label><input class="column-toggle" type="checkbox" value="remarks" checked>Remarks</label>
          <label><input class="column-toggle" type="checkbox" value="brand" checked>Brand</label>
          <label><input class="column-toggle" type="checkbox" value="unit" checked>Unit</label>
          <label><input class="column-toggle" type="checkbox" value="gst" checked>GST %</label>
          <label><input class="column-toggle" type="checkbox" value="selling_price" checked>Selling Price</label>
          <label><input class="column-toggle" type="checkbox" value="price" checked>Price</label>
          <label><input class="column-toggle" type="checkbox" value="stock" checked>Quantity</label>
          <label><input class="column-toggle" type="checkbox" value="rating" checked>Rating</label>
          <label><input class="column-toggle" type="checkbox" value="status" checked>Status</label>
          <label><input class="column-toggle" type="checkbox" value="action" checked>Action</label>
        </div>
      </div>
    </div>

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
            <td data-col="material_code">{{ $product->material_code }}</td>
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
            <td data-col="rating">{{ $product->rating }}</td>
            <td data-col="status">
              <span class="badge">{{ $product->status }}</span>
            </td>
            <td data-col="action">
              <a class="btn" href="{{ route('products.edit', $product) }}">
                Edit
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="15">No products found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="pagination">
      {{ $products->links() }}
    </div>
  </div>

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
          if (cell) {
            cell.style.display = visible ? '' : 'none';
          }
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
</body>

</html>