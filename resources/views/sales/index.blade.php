@extends('layouts.app')

@section('title', 'Sales History')

@section('styles')
<style>
    .search-section { margin-bottom: 20px; }
    .search-section form { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .search-section input { padding: 10px 14px 10px 38px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; width: 320px; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E") 12px center no-repeat; background-size: 18px; }
    .search-section input:focus { outline: none; border-color: var(--accent); }
    .actions { display: flex; gap: 6px; flex-wrap: wrap; }
    @media (max-width: 768px) { .search-section input { width: 100%; } }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-receipt"></i> Sales History</h1>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Dashboard</a>
            <a href="{{ route('sales.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> New Sale</a>
        </div>
    </div>

    <div class="search-section">
        <form method="GET">
            <input type="text" name="search" placeholder="Search invoice or customer" value="{{ $search }}">
            <button class="btn" type="submit"><i class="fas fa-search"></i> Search</button>
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th width="320">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td><strong>{{ $sale->invoice_no }}</strong></td>
                        <td><i class="fas fa-clock" style="color:var(--text-muted);margin-right:4px;"></i>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                        <td><i class="fas fa-user" style="color:var(--text-muted);margin-right:4px;"></i>{{ $sale->customer_name }}</td>
                        <td><strong>₹{{ number_format($sale->grand_total, 2) }}</strong></td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-sm btn-accent" href="{{ route('sales.show', $sale) }}"><i class="fas fa-eye"></i> View</a>
                                <a class="btn btn-sm" href="{{ route('sales.download', $sale) }}"><i class="fas fa-download"></i> Invoice</a>
                                <a class="btn btn-sm btn-outline" href="{{ route('sales.challan.show', $sale) }}"><i class="fas fa-truck"></i> Challan</a>
                                <a class="btn btn-sm btn-outline" href="{{ route('sales.edit', $sale) }}"><i class="fas fa-edit"></i> Edit</a>
                                <a class="btn btn-sm btn-outline" href="{{ route('sales.challan.download', $sale) }}"><i class="fas fa-download"></i> Challan</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state"><i class="fas fa-inbox"></i><p>No sales found.</p></div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $sales->links() }}</div>
</div>
@endsection
