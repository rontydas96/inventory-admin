@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    .stat-card { cursor: default; }
    .stat-card .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .stat-card .stat-icon.blue { background: #dbeafe; color: #1d4ed8; }
    .stat-card .stat-icon.green { background: #dcfce7; color: #16a34a; }
    .stat-card .stat-icon.amber { background: #fef3c7; color: #d97706; }
    .stat-card .stat-icon.red { background: #fee2e2; color: #dc2626; }
    .stat-card .stat-icon.purple { background: #ede9fe; color: #7c3aed; }
    .stat-card .stat-icon.teal { background: #ccfbf1; color: #0d9488; }
    .quick-actions { display: flex; flex-wrap: wrap; gap: 12px; }
    .quick-actions a { flex: 1; min-width: 140px; padding: 16px 20px; border-radius: var(--radius); border: 1px solid var(--glass-border); background: rgba(255,255,255,0.65); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); text-decoration: none; color: var(--text); display: flex; flex-direction: column; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; transition: all .15s ease; box-shadow: var(--shadow); }
    .quick-actions a:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); border-color: var(--accent); }
    .quick-actions a i { font-size: 24px; color: var(--accent); }
    .quick-actions a span { font-size: 12px; color: var(--text-muted); font-weight: 400; }
    @media (max-width: 600px) { .quick-actions a { min-width: 100%; } }
    .charts-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 28px; }
    .chart-card { background: rgba(255,255,255,0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid var(--glass-border); padding: 20px; }
    .chart-card h3 { font-size: 14px; font-weight: 600; color: var(--text-muted); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .chart-card h3 i { color: var(--accent); }
    .chart-card canvas { max-height: 220px; max-width: 100%; }
    .stock-health-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px; }
    .stock-item { padding: 16px; border-radius: var(--radius); border: 1px solid var(--glass-border); background: rgba(255,255,255,0.65); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); }
    .stock-item .label { font-size: 12px; color: var(--text-muted); font-weight: 500; margin-bottom: 8px; }
    .stock-item .bar { height: 8px; border-radius: 999px; background: rgba(0,0,0,0.06); overflow: hidden; margin-bottom: 6px; }
    .stock-item .bar-fill { height: 100%; border-radius: 999px; transition: width .6s ease; }
    .stock-item .count { font-size: 18px; font-weight: 700; }
    @media (max-width: 900px) { .charts-grid, .stock-health-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-boxes"></i></div>
        <div class="stat-info">
            <h3>Total Products</h3>
            <div class="value">{{ number_format($totalProducts) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
            <h3>Active Products</h3>
            <div class="value">{{ number_format($activeProducts) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon amber"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="stat-info">
            <h3>Low Stock (&le;10)</h3>
            <div class="value">{{ number_format($lowStockProducts) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
        <div class="stat-info">
            <h3>Out of Stock</h3>
            <div class="value">{{ number_format($outOfStockProducts) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-shopping-cart"></i></div>
        <div class="stat-info">
            <h3>Total Sales</h3>
            <div class="value">{{ number_format($totalSales) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon teal"><i class="fas fa-wallet"></i></div>
        <div class="stat-info">
            <h3>Today's Revenue</h3>
            <div class="value">₹{{ number_format($todayRevenue, 2) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-chart-line"></i></div>
        <div class="stat-info">
            <h3>Total Revenue</h3>
            <div class="value">₹{{ number_format($totalRevenue, 2) }}</div>
        </div>
    </div>
</div>

<div class="charts-grid">
    <div class="chart-card">
        <h3><i class="fas fa-circle"></i> Product Status</h3>
        <canvas id="statusChart"></canvas>
    </div>
    <div class="chart-card">
        <h3><i class="fas fa-chart-bar"></i> Weekly Sales</h3>
        <canvas id="weeklyChart"></canvas>
    </div>
    <div class="chart-card">
        <h3><i class="fas fa-pie-chart"></i> Categories</h3>
        <canvas id="categoryChart"></canvas>
    </div>
</div>

<div class="stock-health-grid">
    <div class="stock-item">
        <div class="label"><i class="fas fa-check-circle" style="color:#22c55e"></i> Healthy Stock</div>
        <div class="bar"><div class="bar-fill" style="width: {{ $activeProducts > 0 ? round(($healthyStock / $activeProducts) * 100) : 0 }}%; background: #22c55e;"></div></div>
        <div class="count" style="color:#16a34a">{{ $healthyStock }}</div>
    </div>
    <div class="stock-item">
        <div class="label"><i class="fas fa-exclamation-triangle" style="color:#f59e0b"></i> Low Stock (&le;10)</div>
        <div class="bar"><div class="bar-fill" style="width: {{ $activeProducts > 0 ? round(($lowStockProducts / $activeProducts) * 100) : 0 }}%; background: #f59e0b;"></div></div>
        <div class="count" style="color:#d97706">{{ $lowStockProducts }}</div>
    </div>
    <div class="stock-item">
        <div class="label"><i class="fas fa-times-circle" style="color:#ef4444"></i> Out of Stock</div>
        <div class="bar"><div class="bar-fill" style="width: {{ $totalProducts > 0 ? round(($outOfStockProducts / $totalProducts) * 100) : 0 }}%; background: #ef4444;"></div></div>
        <div class="count" style="color:#dc2626">{{ $outOfStockProducts }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
    </div>
    <div class="quick-actions">
        <a href="{{ route('products.create') }}">
            <i class="fas fa-plus-circle"></i>
            Add Product
            <span>Create a new product</span>
        </a>
        <a href="{{ route('sales.create') }}">
            <i class="fas fa-shopping-cart"></i>
            New Sale
            <span>Record a new sale</span>
        </a>
        <a href="{{ route('purchases.create') }}">
            <i class="fas fa-cart-plus"></i>
            New Purchase
            <span>Record a purchase</span>
        </a>
        <a href="{{ route('products.upload') }}">
            <i class="fas fa-upload"></i>
            Upload Excel
            <span>Bulk import products</span>
        </a>
        <a href="{{ route('reports.index') }}">
            <i class="fas fa-chart-bar"></i>
            Reports
            <span>View analytics</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-receipt"></i> Recent Sales</h2>
        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-accent"><i class="fas fa-arrow-right"></i> View All</a>
    </div>

    <div class="table-responsive">
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
                        <td><strong>{{ $sale->invoice_no }}</strong></td>
                        <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $sale->customer_name }}</td>
                        <td class="text-right"><strong>₹{{ number_format($sale->grand_total, 2) }}</strong></td>
                        <td>
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-accent">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>No sales available yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [{{ $activeProducts }}, {{ $inactiveProducts }}],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, font: { family: 'Inter' } } }
            },
            cutout: '65%'
        }
    });

    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($weekLabels) !!},
            datasets: [{
                label: 'Revenue (₹)',
                data: {!! json_encode($weekData) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { callback: v => '₹' + v.toLocaleString() } },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                data: {!! json_encode($categoryData) !!},
                backgroundColor: ['#3b82f6', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#f97316', '#ec4899', '#14b8a6', '#6366f1'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 10, usePointStyle: true, font: { family: 'Inter', size: 11 } } }
            }
        }
    });
});
</script>
@endsection