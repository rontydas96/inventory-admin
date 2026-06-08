<!DOCTYPE html>
<html>

<head>
  <title>Edit Purchase Invoice</title>
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

    input {
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
    <h1>Edit Purchase Invoice</h1>

    <a href="{{ route('purchases.index') }}" class="btn">Back to Purchase List</a>

    <br><br>

    @if($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('purchases.update', $purchase) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="row">
        <div class="col">
          <label>Purchase Invoice No</label>
          <input type="text" name="purchase_invoice_no" value="{{ old('purchase_invoice_no', $purchase->purchase_invoice_no) }}" required>
        </div>

        <div class="col">
          <label>Purchase Date</label>
          <input type="date" name="purchase_date" value="{{ old('purchase_date', optional($purchase->purchase_date)->format('Y-m-d')) }}">
        </div>
      </div>

      <div class="row">
        <div class="col">
          <label>Replace Purchase Invoice PDF (optional)</label>
          <input type="file" name="purchase_invoice_pdf" accept="application/pdf">
        </div>
      </div>

      <button type="submit" class="btn">Save Changes</button>
    </form>
  </div>
</body>

</html>
