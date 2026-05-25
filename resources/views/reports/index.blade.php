<!DOCTYPE html>
<html>

<head>
    <title>Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            padding: 24px;
        }

        .card {
            max-width: 1400px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 20px 55px rgba(15, 23, 42, 0.08);
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
            margin-bottom: 18px;
        }

        .range-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            width: 100%;
            margin-bottom: 10px;
        }

        .range-btn {
            padding: 10px 16px;
            border-radius: 10px;
            background: #eef2ff;
            color: #1e293b;
            border: 1px solid transparent;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: transform 0.15s ease, background 0.15s ease, border-color 0.15s ease;
        }

        .range-btn:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .range-btn.active {
            background: #0f172a;
            color: #fff;
            border-color: #0f172a;
        }

        input,
        select {
            width: 160px;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            color: #0f172a;
            background: #ffffff;
        }

        button,
        .btn {
            padding: 12px 18px;
            border-radius: 10px;
            background: #0f172a;
            color: #ffffff;
            text-decoration: none;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        button:hover,
        .btn:hover {
            background: #020617;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin: 28px 0;
        }

        .stat {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
        }

        .stat h3 {
            margin: 0 0 10px;
            font-size: 13px;
            color: #475569;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .stat .value {
            font-size: 30px;
            font-weight: 700;
            color: #0f172a;
        }

        .stat .subtext {
            margin-top: 8px;
            font-size: 12px;
            color: #64748b;
        }

        .stat.positive .value {
            color: #047857;
        }

        .stat.negative .value {
            color: #b91c1c;
        }

        .positive {
            color: #047857;
        }

        .negative {
            color: #b91c1c;
        }

        .chart-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
            margin-bottom: 24px;
        }

        .chart-title {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .chart-title h2 {
            font-size: 18px;
            margin: 0;
        }

        .chart-meta {
            font-size: 13px;
            color: #64748b;
        }

        .chart-bars {
            display: grid;
            gap: 18px;
        }

        .chart-item {
            display: grid;
            gap: 11px;
        }

        .chart-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #334155;
        }

        .bar-track {
            width: 100%;
            height: 14px;
            background: #e2e8f0;
            border-radius: 999px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: 999px;
            transition: width 0.3s ease;
        }

        .bar-revenue {
            background: #0f172a;
        }

        .bar-purchase {
            background: #2563eb;
        }

        .bar-profit-positive {
            background: #16a34a;
        }

        .bar-profit-negative {
            background: #dc2626;
        }

        .report-table,
        .low-stock-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .report-table th,
        .report-table td,
        .low-stock-table th,
        .low-stock-table td {
            padding: 14px 12px;
            border: 1px solid #e2e7ef;
            text-align: left;
            vertical-align: top;
            font-size: 14px;
        }

        .report-table th,
        .low-stock-table th {
            background: #f8fafc;
            color: #334155;
        }

        .text-right {
            text-align: right;
        }

        .section-title {
            margin-top: 40px;
            font-size: 20px;
            color: #0f172a;
        }

        @media (max-width: 900px) {
            .filters {
                flex-direction: column;
                align-items: stretch;
            }

            input,
            select {
                width: 100%;
            }

            .chart-title {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Reports</h1>

        <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>

        <form method="GET" class="filters">
            <div class="range-buttons">
                <a class="range-btn {{ $range === 'current_month' ? 'active' : '' }}" href="{{ route('reports.index', ['range' => 'current_month']) }}">
                    Current month
                </a>
                <a class="range-btn {{ $range === 'last_month' ? 'active' : '' }}" href="{{ route('reports.index', ['range' => 'last_month']) }}">
                    Last month
                </a>
                <a class="range-btn {{ $range === 'last_30_days' ? 'active' : '' }}" href="{{ route('reports.index', ['range' => 'last_30_days']) }}">
                    Last 30 days
                </a>
                <a class="range-btn {{ $range === 'last_3_months' ? 'active' : '' }}" href="{{ route('reports.index', ['range' => 'last_3_months']) }}">
                    Last 3 months
                </a>
                <a class="range-btn {{ $range === 'last_6_months' ? 'active' : '' }}" href="{{ route('reports.index', ['range' => 'last_6_months']) }}">
                    Last 6 months
                </a>
                <a class="range-btn {{ $range === 'last_year' ? 'active' : '' }}" href="{{ route('reports.index', ['range' => 'last_year']) }}">
                    Last year
                </a>
            </div>

            <div>
                <label>From</label><br>
                <input type="date" name="from" value="{{ $from }}">
            </div>

            <div>
                <label>To</label><br>
                <input type="date" name="to" value="{{ $to }}">
            </div>

            <div>
                <button class="btn" type="submit">Apply filter</button>
            </div>

            <div>
                <a class="btn" href="{{ route('reports.exportSalesCsv', ['from' => $from, 'to' => $to]) }}">
                    Export CSV
                </a>
            </div>
        </form>

        <div class="meta-grid">
            <div class="stat">
                <h3>Total Invoices</h3>
                <div class="value">{{ number_format($invoiceCount) }}</div>
                <div class="subtext">Invoices issued for the selected range.</div>
            </div>

            <div class="stat">
            <h3>Total Revenue</h3>
            <div class="value">₹{{ number_format($totalRevenue, 2) }}</div>
            <div class="subtext">Total selling revenue for filtered sales.</div>
        </div>

        <div class="stat">
            <h3>Total Purchase Cost</h3>
            <div class="value">₹{{ number_format($totalPurchase, 2) }}</div>
            <div class="subtext">Estimated cost based on product purchase prices.</div>
        </div>

        <div class="stat {{ $profitLoss >= 0 ? 'positive' : 'negative' }}">
            <h3>Total Profit / Loss</h3>
            <div class="value">₹{{ number_format($profitLoss, 2) }}</div>
            <div class="subtext">Revenue minus purchase cost for the selected period.</div>
        </div>

        <div class="stat">
            <h3>Average Invoice Value</h3>
            <div class="value">₹{{ number_format($averageInvoice, 2) }}</div>
            <div class="subtext">Average sale value for the chosen date range.</div>
        </div>

        <div class="stat">
            <h3>Revenue Change</h3>
            <div class="value">
                @if($revenueGrowth === null)
                    --
                @else
                    {{ $revenueGrowth >= 0 ? '+' : '' }}{{ number_format($revenueGrowth, 2) }}%
                @endif
            </div>
            <div class="subtext">Compared to {{ $previousFrom->format('d M Y') }} – {{ $previousTo->format('d M Y') }}.</div>
        </div>

        <div class="stat {{ $profitGrowth !== null && $profitGrowth >= 0 ? 'positive' : 'negative' }}">
            <h3>Profit Change</h3>
            <div class="value">
                @if($profitGrowth === null)
                    --
                @else
                    {{ $profitGrowth >= 0 ? '+' : '' }}{{ number_format($profitGrowth, 2) }}%
                @endif
            </div>
            <div class="subtext">Performance versus the prior period.</div>
        </div>
        </div>

        <div class="chart-card">
            <div class="chart-title">
                <h2>Profit Analysis</h2>
                <div class="chart-meta">Graphical insights for the selected date filter.</div>
            </div>
            @php
                $chartMax = max($totalRevenue, $totalPurchase, abs($profitLoss), 1);
                $revenueWidth = $totalRevenue > 0 ? ($totalRevenue / $chartMax) * 100 : 0;
                $purchaseWidth = $totalPurchase > 0 ? ($totalPurchase / $chartMax) * 100 : 0;
                $profitWidth = abs($profitLoss) > 0 ? (abs($profitLoss) / $chartMax) * 100 : 0;
            @endphp
            <div class="chart-bars">
                <div class="chart-item">
                    <div class="chart-label">
                        <span>Revenue</span>
                        <span>₹{{ number_format($totalRevenue, 2) }}</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill bar-revenue" style="width: {{ $revenueWidth }}%;"></div>
                    </div>
                </div>
                <div class="chart-item">
                    <div class="chart-label">
                        <span>Purchase Cost</span>
                        <span>₹{{ number_format($totalPurchase, 2) }}</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill bar-purchase" style="width: {{ $purchaseWidth }}%;"></div>
                    </div>
                </div>
                <div class="chart-item">
                    <div class="chart-label">
                        <span>Profit / Loss</span>
                        <span>₹{{ number_format($profitLoss, 2) }}</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill {{ $profitLoss >= 0 ? 'bar-profit-positive' : 'bar-profit-negative' }}" style="width: {{ $profitWidth }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th class="text-right">Revenue</th>
                    <th class="text-right">Purchase Cost</th>
                    <th class="text-right">GST</th>
                    <th class="text-right">Profit / Loss</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    @php
                        $salePurchase = $sale->items->sum(function ($item) {
                            return ($item->product?->price ?? 0) * $item->quantity;
                        });
                        $saleProfit = $sale->grand_total - $salePurchase;
                    @endphp
                    <tr>
                        <td>{{ $sale->invoice_no }}</td>
                        <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $sale->customer_name }}</td>
                        <td class="text-right">₹{{ number_format($sale->grand_total, 2) }}</td>
                        <td class="text-right">₹{{ number_format($salePurchase, 2) }}</td>
                        <td class="text-right">₹{{ number_format($sale->gst_amount, 2) }}</td>
                        <td class="text-right {{ $saleProfit >= 0 ? 'positive' : 'negative' }}">
                            ₹{{ number_format($saleProfit, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No sales found for the selected date range.</td>
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