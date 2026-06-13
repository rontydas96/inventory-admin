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

    @php
      $purchasePdfExists = $purchase->purchase_invoice_pdf && \Illuminate\Support\Facades\Storage::exists($purchase->purchase_invoice_pdf);
    @endphp

    <a href="{{ route('purchases.index') }}" class="btn">Back to Purchase List</a>
    @if($purchasePdfExists)
      <a href="{{ route('purchases.download', $purchase) }}" class="btn">Download Invoice PDF</a>
    @else
      <span class="btn" style="background:#6b7280; cursor:default;">No PDF available</span>
    @endif

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
      <span>{{ optional($purchase->purchase_date)->format('d-m-Y') }}</span>
    </div>
  </div>
</body>

</html>
