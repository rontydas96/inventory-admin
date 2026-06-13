<!DOCTYPE html>
<html>

<head>
  <title>Purchase Invoices</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8fafc;
      padding: 40px;
    }

    .card {
      max-width: 1200px;
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
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      padding: 12px;
      border: 1px solid #e5e7eb;
      text-align: left;
    }

    th {
      background: #f1f5f9;
    }

    .actions a {
      margin-right: 10px;
    }

    .header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }

    .search-bar {
      margin-top: 10px;
    }

    .search-bar input {
      width: 300px;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #d1d5db;
    }
  </style>
</head>

<body>
    <div class="card">
        <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
    </div>
  <div class="card">
    <div class="header-row">
      <div>
        <h1>Purchase Invoices</h1>
      </div>
      <div>
        <a href="{{ route('purchases.create') }}" class="btn">Add Purchase</a>
      </div>
    </div>

    @if(session('success'))
      <div style="background:#d1fae5;color:#065f46;padding:12px;border-radius:6px;margin-bottom:18px;">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:6px;margin-bottom:18px;">
        {{ session('error') }}
      </div>
    @endif

    <form class="search-bar" method="GET" action="{{ route('purchases.index') }}">
      <input type="text" name="search" placeholder="Search invoice or product" value="{{ $search }}">
      <button type="submit" class="btn">Search</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Invoice No</th>
          <th>Uploaded At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($purchases as $purchase)
          @php
            $purchasePdfExists = $purchase->purchase_invoice_pdf && \Illuminate\Support\Facades\Storage::exists($purchase->purchase_invoice_pdf);
          @endphp
          <tr>
            <td>{{ $purchase->purchase_invoice_no }}</td>
            <td>{{ optional($purchase->purchase_date)->format('d-m-Y') }}</td>
            <td class="actions">
              <a href="{{ route('purchases.show', $purchase) }}">Show</a>
              <a href="{{ route('purchases.edit', $purchase) }}">Edit</a>
              <form method="POST" action="{{ route('purchases.destroy', $purchase) }}" style="display:inline;" onsubmit="return confirm('Delete this purchase invoice?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background:#dc2626;">Delete</button>
              </form>
              @if($purchasePdfExists)
                <a href="{{ route('purchases.download', $purchase) }}">Download</a>
              @else
                <span style="color:#999;">No PDF</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3">No purchase invoices found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div style="margin-top:20px;">
      {{ $purchases->links() }}
    </div>
  </div>
</body>

</html>
