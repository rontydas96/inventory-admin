<!DOCTYPE html>
<html>

<head>
  <title>Purchase Invoice {{ $purchase->purchase_invoice_no }}</title>
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

    .btn {
      padding: 10px 18px;
      background: #0f172a;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      margin-right: 10px;
    }

    .field {
      margin-bottom: 16px;
    }

    .field strong {
      display: block;
      margin-bottom: 6px;
      color: #334155;
    }
  </style>
</head>

<body>
  <div class="card">
    <h1>Purchase Invoice Details</h1>

    <a href="{{ route('purchases.index') }}" class="btn">Back to Purchase List</a>
    <a href="{{ route('purchases.download', $purchase) }}" class="btn">Download Invoice PDF</a>

    <div class="field">
      <strong>Invoice Number</strong>
      <span>{{ $purchase->purchase_invoice_no }}</span>
    </div>

    <div class="field">
      <strong>Products Material Code:</strong>
      <span>{{ $purchase->product_codes ?: 'None' }}</span>
    </div>

    <div class="field">
      <strong>Uploaded At</strong>
      <span>{{ $purchase->created_at->format('d-m-Y H:i') }}</span>
    </div>
  </div>
</body>

</html>
