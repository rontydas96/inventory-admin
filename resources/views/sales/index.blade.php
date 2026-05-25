<!DOCTYPE html>
<html>

<head>
    <title>Sales History</title>
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
            border: none;
            border-radius: 6px;
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
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
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
        <h1>Sales History</h1>

        <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
        <a href="{{ route('sales.create') }}" class="btn">New Sale</a>

        <form method="GET" style="margin-top: 20px;">
            <input type="text" name="search" placeholder="Search invoice or customer" value="{{ $search }}">
            <button class="btn" type="submit">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th width="220">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->invoice_no }}</td>
                        <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $sale->customer_name }}</td>
                        <td>₹{{ number_format($sale->grand_total, 2) }}</td>
                        <td>
                            <a class="btn" href="{{ route('sales.show', $sale) }}">
                                View
                            </a>

                            <a class="btn" href="{{ route('sales.download', $sale) }}">
                                Download Invoice
                            </a>

                            <a class="btn" href="{{ route('sales.challan.show', $sale) }}">
                                View Challan
                            </a>

                            <a class="btn" href="{{ route('sales.challan.download', $sale) }}">
                                Download Challan
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No sales found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $sales->links() }}
        </div>
    </div>
</body>

</html>