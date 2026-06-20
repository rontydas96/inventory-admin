@extends('layouts.app')

@section('title', 'Purchase Invoices')

@section('styles')
<style>
    .search-section { margin-bottom: 20px; }
    .search-section form { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .search-section input { padding: 10px 14px 10px 38px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; width: 320px; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E") 12px center no-repeat; background-size: 18px; }
    .search-section input:focus { outline: none; border-color: var(--accent); }
    .actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
</style>
@endsection

@section('content')
<div class="card" style="padding:16px 28px;">
    <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Dashboard</a>
</div>

<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-truck-loading"></i> Purchase Invoices</h1>
        <a href="{{ route('purchases.create') }}" class="btn"><i class="fas fa-plus"></i> Add Purchase</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="search-section">
        <form method="GET" action="{{ route('purchases.index') }}">
            <input type="text" name="search" placeholder="Search invoice or product" value="{{ $search }}">
            <button type="submit" class="btn"><i class="fas fa-search"></i> Search</button>
        </form>
    </div>

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
                    <td><strong>{{ $purchase->purchase_invoice_no }}</strong></td>
                    <td><i class="fas fa-clock" style="color:var(--text-muted);margin-right:6px;"></i>{{ $purchase->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-sm btn-accent"><i class="fas fa-eye"></i> Show</a>
                            <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <form method="POST" action="{{ route('purchases.destroy', $purchase) }}" style="display:inline;" onsubmit="return confirm('Delete this purchase invoice?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                            @if($purchasePdfExists)
                                <a href="{{ route('purchases.download', $purchase) }}" class="btn btn-sm btn-outline"><i class="fas fa-download"></i> PDF</a>
                            @else
                                <span style="color:var(--text-muted);font-size:13px;"><i class="fas fa-file-pdf" style="margin-right:4px;"></i>No PDF</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state"><i class="fas fa-inbox"></i><p>No purchase invoices found.</p></div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">{{ $purchases->links() }}</div>
</div>
@endsection
