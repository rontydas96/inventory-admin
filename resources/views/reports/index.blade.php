<!DOCTYPE html>
<html>

<head>
    <title>Reports</title>
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

        .filters {
            display: flex;
            gap: 10px;
            align-items: end;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        input {
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }

        .btn {
            padding: 10px 16px;
            background: #0f172a;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            display: inline-block;
            cursor: pointer;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin: 25px 0;
        }

        .stat {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
        }

        .stat h3 {
            margin: 0 0 10px;
            font-size: 14px;
            color: #64748b;
        }

        .stat .value {
            font-size: 28px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f1f5f9;
        }

        .text-right {
            text-align: right;
        }

        h1 {
            margin-top: 0;
        }

        .section-title {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Reports</h1>

        <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>

        <form method="GET" class="filters">
            <div>
                <label>From</label><br>
                <input type="date" name="from" value="{{ $from }}">
            </div>

            <div>
                <label>To</label><br>
                <input type="date" name="to" value="{{ $to }}">
            </div>

            <div>
                <button class="btn" type="submit">Filter</button>
            </div>

            <div>
                <a class="btn" href="{{ route('reports.exportSalesCsv', ['from' => $from, 'to' => $to]) }}">
                    Export CSV
                </a>
            </div>
        </form>

        <div class="stats">
            <div class="stat">
                <h3>Total Invoices</h3>
                <div class="value">{{ number_format($invoiceCount) }}</div>
            </div>

            <div class="stat">
                <h3>Total Revenue</h3>
                <div class="value">₹{{ number_format($totalRevenue, 2) }}</div>
            </div>

            <div class="stat">
                <h3>Total GST</h3>
                <div class="value">₹{{ number_format($totalTax, 2) }}</div>
            </div>
        </div>

        <h2>Sales Report</h2>

        <table>
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->invoice_no }}</td>
                        <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $sale->customer_name }}</td>
                        <td class="text-right">
                            ₹{{ number_format($sale->grand_total, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No sales found for the selected date range.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h2 class="section-title">Low Stock Products (≤10)</h2>

        <table>
            <thead>
                <tr>
                    <th>Material No</th>
                    <th>Product</th>
                    <th>Brand</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->material_code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->brand }}</td>
                        <td>{{ $product->stock_level }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No low stock products.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>