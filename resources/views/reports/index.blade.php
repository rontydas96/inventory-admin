@extends('layouts.app')

@section('title', 'Reports')

@section('styles')
<style>
    .filters { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; margin-bottom: 18px; }
    .range-buttons { display: flex; flex-wrap: wrap; gap: 8px; width: 100%; margin-bottom: 10px; }
    .range-btn { padding: 9px 16px; border-radius: 8px; background: #f1f5f9; color: var(--text); border: 1px solid var(--border); text-decoration: none; font-size: 13px; font-weight: 500; transition: all .15s ease; }
    .range-btn:hover { background: #e2e8f0; border-color: #cbd5e1; }
    .range-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); }
    input, select { width: 160px; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border); font-size: 14px; font-family: inherit; color: var(--text); background: #fff; transition: border .15s ease; }
    input:focus, select:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
    label { font-size: 13px; font-weight: 500; color: var(--text-muted); margin-bottom: 4px; display: block; }
    .chart-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 24px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .chart-title { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 14px; margin-bottom: 20px; }
    .chart-title h2 { font-size: 18px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
    .chart-title h2 i { color: var(--accent); }
    .chart-meta { font-size: 13px; color: var(--text-muted); }
    .chart-bars { display: grid; gap: 18px; }
    .chart-item { display: grid; gap: 11px; }
    .chart-label { display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: var(--text); }
    .bar-track { width: 100%; height: 14px; background: var(--border); border-radius: 999px; overflow: hidden; }
    .bar-fill { height: 100%; border-radius: 999px; transition: width 0.3s ease; }
    .bar-revenue { background: var(--primary); }
    .bar-purchase { background: var(--accent); }
    .bar-profit-positive { background: var(--success); }
    .bar-profit-negative { background: var(--danger); }
    .section-title { margin-top: 40px; font-size: 20px; font-weight: 600; color: var(--text); display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
    .section-title i { color: var(--accent); }
    .empty-state { text-align: center; padding: 48px 20px; color: var(--text-muted); }
    .empty-state i { font-size: 48px; color: var(--border); margin-bottom: 16px; }

    @media (max-width: 900px) {
        .filters { flex-direction: column; align-items: stretch; }
        .chart-title { flex-direction: column; align-items: flex-start; }
    }
</style>
@endsection

@section('content')
<div class="card">
    <h1 style="font-size:22px;font-weight:700;display:flex;align-items:center;gap:10px;margin-bottom:20px;"><i class="fas fa-chart-bar" style="color:var(--accent);"></i> Reports</h1>

    <a href="{{ route('dashboard') }}" class="btn" style="margin-bottom:20px;"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

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
            <button class="btn" type="submit"><i class="fas fa-filter"></i> Apply filter</button>
        </div>

        <div>
            <a class="btn" href="{{ route('reports.exportSalesCsv', ['from' => $from, 'to' => $to]) }}">
                <i class="fas fa-download"></i> Export CSV
            </a>
        </div>
    </form>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-file-invoice"></i></div>
            <div class="stat-info">
                <h3>Total Invoices</h3>
                <div class="value">{{ number_format($invoiceCount) }}</div>
                <div class="subtext">Invoices issued for the selected range.</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-rupee-sign"></i></div>
            <div class="stat-info">
                <h3>Total Revenue</h3>
                <div class="value">₹{{ number_format($totalRevenue, 2) }}</div>
                <div class="subtext">Total selling revenue for filtered sales.</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-info">
                <h3>Total Purchase Cost</h3>
                <div class="value">₹{{ number_format($totalPurchase, 2) }}</div>
                <div class="subtext">Estimated cost based on product purchase prices.</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon {{ $profitLoss >= 0 ? 'green' : 'red' }}"><i class="fas fa-chart-line"></i></div>
            <div class="stat-info">
                <h3>Total Profit / Loss</h3>
                <div class="value" style="color: {{ $profitLoss >= 0 ? 'var(--success)' : 'var(--danger)' }};">₹{{ number_format($profitLoss, 2) }}</div>
                <div class="subtext">Revenue minus purchase cost for the selected period.</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-chart-bar"></i></div>
            <div class="stat-info">
                <h3>Average Invoice Value</h3>
                <div class="value">₹{{ number_format($averageInvoice, 2) }}</div>
                <div class="subtext">Average sale value for the chosen date range.</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon gray"><i class="fas fa-percent"></i></div>
            <div class="stat-info">
                <h3>Revenue Change</h3>
                <div class="value">
                    @if($revenueGrowth === null)
                        --
                    @else
                        <span style="color: {{ $revenueGrowth >= 0 ? 'var(--success)' : 'var(--danger)' }};">{{ $revenueGrowth >= 0 ? '+' : '' }}{{ number_format($revenueGrowth, 2) }}%</span>
                    @endif
                </div>
                <div class="subtext">Compared to {{ $previousFrom->format('d M Y') }} – {{ $previousTo->format('d M Y') }}.</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon {{ $profitGrowth !== null && $profitGrowth >= 0 ? 'green' : 'red' }}"><i class="fas fa-arrow-up"></i></div>
            <div class="stat-info">
                <h3>Profit Change</h3>
                <div class="value">
                    @if($profitGrowth === null)
                        --
                    @else
                        <span style="color: {{ $profitGrowth >= 0 ? 'var(--success)' : 'var(--danger)' }};">{{ $profitGrowth >= 0 ? '+' : '' }}{{ number_format($profitGrowth, 2) }}%</span>
                    @endif
                </div>
                <div class="subtext">Performance versus the prior period.</div>
            </div>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-title">
            <h2><i class="fas fa-chart-pie"></i> Profit Analysis</h2>
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

    <h2 class="section-title"><i class="fas fa-exclamation-triangle"></i> Low Stock Products (&le;10)</h2>

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
@endsection
