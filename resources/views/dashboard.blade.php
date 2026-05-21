<!DOCTYPE html>
<html>

<head>
    <title>Inventory Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            padding: 30px;
            margin: 0;
        }

        .container {
            max-width: 1300px;
            margin: auto;
        }

        .header {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
            margin-bottom: 25px;
        }

        .nav {
            margin-top: 15px;
        }

        .nav a,
        .nav button {
            display: inline-block;
            margin: 6px 8px 6px 0;
            padding: 10px 16px;
            background: #0f172a;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        form.inline {
            display: inline;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: #fff;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        .stat-card h3 {
            margin: 0 0 10px;
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .stat-card .value {
            font-size: 30px;
            font-weight: bold;
            color: #0f172a;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
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

        .text-right {
            text-align: right;
        }

        .welcome {
            color: #64748b;
            margin-top: 6px;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="header">
            <h1>Inventory Dashboard</h1>
            <p class="welcome">
                Welcome, {{ session('admin_email') }}
            </p>

            <div class="nav">
                <a href="{{ route('products.upload') }}">Upload Products</a>
                <a href="{{ route('products.index') }}">Products</a>
                <a href="{{ route('sales.create') }}">New Sale</a>
                <a href="{{ route('sales.index') }}">Sales History</a>
                <a href="{{ route('settings.edit') }}">Settings</a>
                <a href="{{ route('reports.index') }}">Reports</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats">
            <div class="stat-card">
                <h3>Total Products</h3>
                <div class="value">{{ number_format($totalProducts) }}</div>
            </div>

            <div class="stat-card">
                <h3>Active Products</h3>
                <div class="value">{{ number_format($activeProducts) }}</div>
            </div>

            <div class="stat-card">
                <h3>Low Stock (≤10)</h3>
                <div class="value">{{ number_format($lowStockProducts) }}</div>
            </div>

            <div class="stat-card">
                <h3>Out of Stock</h3>
                <div class="value">{{ number_format($outOfStockProducts) }}</div>
            </div>

            <div class="stat-card">
                <h3>Total Invoices</h3>
                <div class="value">{{ number_format($totalSales) }}</div>
            </div>

            <div class="stat-card">
                <h3>Total Revenue</h3>
                <div class="value">₹{{ number_format($totalRevenue, 2) }}</div>
            </div>

            <div class="stat-card">
                <h3>Today's Revenue</h3>
                <div class="value">₹{{ number_format($todayRevenue, 2) }}</div>
            </div>
        </div>

        <!-- Recent Sales -->
        <div class="card">
            <h2>Recent Sales</h2>

            <table>
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th class="text-right">Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales as $sale)
                        <tr>
                            <td>{{ $sale->invoice_no }}</td>
                            <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $sale->customer_name }}</td>
                            <td class="text-right">
                                ₹{{ number_format($sale->grand_total, 2) }}
                            </td>
                            <td>
                                <a href="{{ route('sales.show', $sale) }}">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No sales available yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>