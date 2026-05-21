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

    input {
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

    @if(session('success'))
      <p style="color: green; margin-top: 20px;">
        {{ session('success') }}
      </p>
    @endif

    <form method="GET" style="margin-top: 20px;">
      <input type="text" name="search" placeholder="Search by SKU or name" value="{{ $search }}">
      <button class="btn" type="submit">Search</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>SKU</th>
          <th>Name</th>
          <th>Main Category</th>
          <th>Sub Category</th>
          <th>Brand</th>
          <th>Unit</th>
          <th>GST %</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Rating</th>
          <th>Status</th>
          <th width="100">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
          <tr>
            <td>{{ $product->product_id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->main_category }}</td>
            <td>{{ $product->category }}</td>
            <td>{{ $product->brand }}</td>
            <td>{{ $product->unit }}</td>
            <td>{{ $product->applied_gst }}%</td>
            <td>₹{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->stock_level }}</td>
            <td>{{ $product->rating }}</td>
            <td>
              <span class="badge">{{ $product->status }}</span>
            </td>
            <td>
              <a class="btn" href="{{ route('products.edit', $product) }}">
                Edit
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9">No products found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="pagination">
      {{ $products->links() }}
    </div>
  </div>
</body>

</html>