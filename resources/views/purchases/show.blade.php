@extends('layouts.app')

@section('title', 'Purchase Invoice ' . $purchase->purchase_invoice_no)

@section('styles')
<style>
    .btn-disabled { background: #6b7280; cursor: default; opacity: .7; }
    .detail-grid { display: grid; gap: 24px; margin-top: 24px; }
    .detail-item { background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; padding: 18px; }
    .detail-item .label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: var(--text-muted); margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
    .detail-item .value { font-size: 15px; font-weight: 500; color: var(--text); }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-file-invoice"></i> Purchase Invoice Details</h1>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('purchases.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Purchase List</a>
            @php
                $purchasePdfExists = $purchase->purchase_invoice_pdf && \Illuminate\Support\Facades\Storage::exists($purchase->purchase_invoice_pdf);
            @endphp
            @if($purchasePdfExists)
                <a href="{{ route('purchases.download', $purchase) }}" class="btn btn-accent"><i class="fas fa-download"></i> Download Invoice PDF</a>
            @else
                <span class="btn btn-disabled"><i class="fas fa-file-pdf"></i> No PDF available</span>
            @endif
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <div class="label"><i class="fas fa-hashtag"></i> Invoice Number</div>
            <div class="value">{{ $purchase->purchase_invoice_no }}</div>
        </div>
        <div class="detail-item">
            <div class="label"><i class="fas fa-box"></i> Products Material Code</div>
            <div class="value">{{ $purchase->product_codes ?: 'None' }}</div>
        </div>
        <div class="detail-item">
            <div class="label"><i class="fas fa-clock"></i> Uploaded At</div>
            <div class="value">{{ $purchase->created_at->format('d-m-Y H:i') }}</div>
        </div>
    </div>
</div>
@endsection
