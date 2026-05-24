<!DOCTYPE html>
<html>

<head>
  <title>Add Product</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8fafc;
      padding: 40px;
    }

    .card {
      max-width: 900px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
    }

    .row {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .col {
      flex: 1;
      min-width: 220px;
    }

    input,
    select {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      margin-bottom: 15px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      box-sizing: border-box;
    }

    .btn {
      padding: 10px 18px;
      background: #0f172a;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }

    .error {
      background: #fee2e2;
      color: #991b1b;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    h1 {
      margin-top: 0;
    }
  </style>
</head>

<body>
  <div class="card">
    <h1>Add Product</h1>

    <a href="{{ route('products.index') }}" class="btn">Back to Products</a>

    <br><br>

    @if($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('products.store') }}">
      @csrf

      <div class="row">
        <div class="col">
          <label>Material No</label>
          <input type="text" name="material_code" value="{{ old('material_code') }}" required>
        </div>

        <div class="col">
          <label>Product Name</label>
          <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="col">
          <label>HSN Code</label>
          <input type="text" name="hsn_code" value="{{ old('hsn_code') }}">
        </div>
      </div>

      <div class="row">

        <div class="col">
          <label>Main Category</label>
          <input type="text" name="main_category" value="{{ old('main_category') }}">
        </div>

        <div class="col">
          <label>Category</label>
          <input type="text" name="category" value="{{ old('category') }}">
        </div>

      </div>

      <div class="row">
        <div class="col">
          <label>Price</label>
          <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required>
        </div>

        <div class="col">
          <label>Selling Price</label>
          <input type="number" step="0.01" min="0" name="selling_price" value="{{ old('selling_price') }}">
        </div>

        <div class="col">
          <label>Stock Level</label>
          <input type="number" min="0" name="stock_level" value="{{ old('stock_level') }}" required>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <label>GST %</label>
          <input type="number" step="0.01" min="0" max="100" name="gst_percentage" value="{{ old('gst_percentage') }}">
        </div>

        <div class="col">
          <label>Rating</label>
          <input type="number" step="0.1" min="0" max="5" name="rating" value="{{ old('rating') }}">
        </div>

        <div class="col">
          <label>Status</label>
          <select name="status" required>
            <option value="Active" @selected(old('status') === 'Active')>Active</option>
            <option value="Out of Stock" @selected(old('status') === 'Out of Stock')>Out of Stock</option>
            <option value="Discontinued" @selected(old('status') === 'Discontinued')>Discontinued</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <label>Brand</label>
          <input type="text" name="brand" value="{{ old('brand') }}">
        </div>

        <div class="col">
          <label>Unit</label>
          <input type="text" name="unit" value="{{ old('unit') }}">
        </div>
      </div>

      <button type="submit" class="btn">
        Save Product
      </button>
    </form>
  </div>
</body>

</html>
