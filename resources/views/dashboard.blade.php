@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <style>

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
        }

        .stat-card .value {
            font-size: 30px;
            font-weight: bold;
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
        }

        th {
            background: #f1f5f9;
        }

        .text-right {
            text-align: right;
        }

    </style>
@endsection

@section('content')

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

                    <td>
                        {{ $sale->created_at->format('d-m-Y H:i') }}
                    </td>

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
                    <td colspan="5">
                        No sales available yet.
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>

</div>

@endsection