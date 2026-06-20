@extends('layouts.app')

@section('title', $sale->invoice_no)

@section('styles')
<style>
    .card { padding: 0; overflow: hidden; }
    .success-header {
        background: #eef2ff;
        border-bottom: 1px solid var(--border);
        padding: 1.25rem 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .success-left { display: flex; align-items: center; gap: 12px; }
    .success-icon {
        width: 38px; height: 38px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #fff;
        font-size: 16px;
    }
    .success-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 2px;
    }
    .success-sub { font-size: 12.5px; color: var(--text-muted); }
    .invoice-badge {
        background: var(--primary);
        color: #fff;
        font-size: 12px;
        font-weight: 500;
        padding: 5px 14px;
        border-radius: var(--radius-sm);
        white-space: nowrap;
        letter-spacing: 0.03em;
    }
    .card-body { padding: 1.75rem; display: flex; flex-direction: column; gap: 1.75rem; }
    .section-label {
        font-size: 10.5px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .section-label i { font-size: 13px; color: var(--accent); }
    .fields-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
        gap: 8px;
    }
    .field-card {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 10px 13px;
    }
    .field-card.full-width { grid-column: 1 / -1; }
    .field-label { font-size: 11px; color: var(--text-muted); margin-bottom: 3px; }
    .field-value {
        font-size: 13.5px;
        font-weight: 500;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .field-value.wrap { white-space: normal; }
    .divider { height: 1px; background: var(--border); }
    .table-wrap {
        border-radius: var(--radius-md);
        border: 1px solid var(--border);
        overflow: hidden;
        overflow-x: auto;
    }
    table.products {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 560px;
    }
    table.products thead tr { background: var(--bg); }
    table.products th {
        font-size: 10.5px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.07em;
        padding: 10px 14px;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
        text-align: left;
    }
    table.products th.r, table.products td.r { text-align: right; }
    table.products th.c, table.products td.c { text-align: center; }
    table.products td {
        padding: 11px 14px;
        border-bottom: 1px solid var(--border);
        color: var(--text);
        vertical-align: middle;
    }
    table.products tbody tr:last-child td { border-bottom: none; }
    table.products tbody tr:nth-child(even) td { background: #fafafa; }
    .sku-cell, .hsn-cell {
        font-size: 11.5px;
        color: var(--text-muted);
    }
    .product-name { font-weight: 500; }
    .totals-row { display: flex; justify-content: flex-end; }
    .totals-card {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        overflow: hidden;
        min-width: 260px;
    }
    .total-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 11px 16px;
        font-size: 13.5px;
        border-bottom: 1px solid var(--border);
    }
    .total-line:last-child {
        border-bottom: none;
        background: var(--primary);
        color: #fff;
        font-size: 14.5px;
        font-weight: 600;
        padding: 13px 16px;
    }
    .total-line-label { color: var(--text-muted); font-size: 13px; }
    .total-line-value { font-weight: 500; font-size: 13px; }
    .total-line:last-child .total-line-label,
    .total-line:last-child .total-line-value { color: #fff; font-size: 14px; }
    .actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        font-size: 13.5px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s ease;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text);
    }
    .btn:hover { background: var(--bg); border-color: var(--border); }
    .btn i { font-size: 14px; }
    .btn-primary {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    .btn-primary:hover { background: #1e293b; border-color: #1e293b; }
    @media print {
        body { background: white; padding: 0; }
        .card { box-shadow: none; border: none; }
        .actions { display: none; }
    }
    @media (max-width: 600px) {
        .card-body { padding: 1.25rem; }
        .success-header { padding: 1rem 1.25rem; }
        .fields-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="success-header">
        <div class="success-left">
            <div class="success-icon"><i class="fas fa-check"></i></div>
            <div>
                <p class="success-title">Sale completed successfully</p>
                <p class="success-sub">Invoice No: <strong>{{ $sale->invoice_no }}</strong></p>
            </div>
        </div>
        <span class="invoice-badge">{{ $sale->invoice_no }}</span>
    </div>

    <div class="card-body">
        <div>
            <p class="section-label"><i class="fas fa-user"></i> Customer details</p>
            <div class="fields-grid">
                <div class="field-card">
                    <p class="field-label">Customer name</p>
                    <p class="field-value">{{ $sale->customer_name }}</p>
                </div>
                <div class="field-card">
                    <p class="field-label">Phone</p>
                    <p class="field-value">{{ $sale->customer_phone ?: '-' }}</p>
                </div>
                <div class="field-card">
                    <p class="field-label">Email</p>
                    <p class="field-value">{{ $sale->customer_email ?: '-' }}</p>
                </div>
                <div class="field-card">
                    <p class="field-label">PO No</p>
                    <p class="field-value">{{ $sale->po_no ?: '-' }}</p>
                </div>
                <div class="field-card">
                    <p class="field-label">Challan No</p>
                    <p class="field-value">{{ $sale->challan_no ?: '-' }}</p>
                </div>
                <div class="field-card">
                    <p class="field-label">Vehicle No</p>
                    <p class="field-value">{{ $sale->vehicle_no ?: '-' }}</p>
                </div>
                <div class="field-card">
                    <p class="field-label">E-way Bill No</p>
                    <p class="field-value">{{ $sale->ewaybill_no ?: '-' }}</p>
                </div>
                <div class="field-card full-width">
                    <p class="field-label">Subject</p>
                    <p class="field-value wrap">{{ $sale->subject ?: '-' }}</p>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div>
            <p class="section-label"><i class="fas fa-box"></i> Products</p>
            <div class="table-wrap">
                <table class="products">
                    <thead>
                        <tr>
                            <th>Material No</th>
                            <th>Product</th>
                            <th>HSN Code</th>
                            <th class="r">Rate</th>
                            <th class="c">Qty</th>
                            <th class="r">CGST %</th>
                            <th class="r">SGST %</th>
                            <th class="r">CGST Amount</th>
                            <th class="r">SGST Amount</th>
                            <th class="r">Line Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                            @php
                                $halfGstRate = $item->gst_percentage / 2;
                                $halfGstAmount = $item->gst_amount / 2;
                            @endphp
                            <tr>
                                <td class="sku-cell">{{ $item->material_code }}</td>
                                <td class="product-name">{{ $item->product_name }}</td>
                                <td class="hsn-cell">{{ optional($item->product)->hsn_code ?? $item->hsn_code }}</td>
                                <td class="r">₹{{ number_format($item->unit_price, 2) }}</td>
                                <td class="c">{{ $item->quantity }}</td>
                                <td class="r">{{ number_format($halfGstRate, 2) }}%</td>
                                <td class="r">{{ number_format($halfGstRate, 2) }}%</td>
                                <td class="r">₹{{ number_format($halfGstAmount, 2) }}</td>
                                <td class="r">₹{{ number_format($halfGstAmount, 2) }}</td>
                                <td class="r">₹{{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @php
            $saleGstRate = $sale->subtotal > 0 ? ($sale->gst_amount / $sale->subtotal) * 100 : 0;
            $halfSaleGstRate = $saleGstRate / 2;
            $halfSaleGstAmount = $sale->gst_amount / 2;
        @endphp
        <div class="totals-row">
            <div class="totals-card">
                <div class="total-line">
                    <span class="total-line-label">Taxable value</span>
                    <span class="total-line-value">₹{{ number_format($sale->subtotal, 2) }}</span>
                </div>
                <div class="total-line">
                    <span class="total-line-label">Total GST</span>
                    <span class="total-line-value">₹{{ number_format($sale->gst_amount, 2) }}</span>
                </div>
                <div class="total-line">
                    <span class="total-line-label">Total CGST ({{ number_format($halfSaleGstRate, 2) }}%)</span>
                    <span class="total-line-value">₹{{ number_format($halfSaleGstAmount, 2) }}</span>
                </div>
                <div class="total-line">
                    <span class="total-line-label">Total SGST ({{ number_format($halfSaleGstRate, 2) }}%)</span>
                    <span class="total-line-value">₹{{ number_format($halfSaleGstAmount, 2) }}</span>
                </div>
                <div class="total-line">
                    <span class="total-line-label">Grand total</span>
                    <span class="total-line-value">₹{{ number_format($sale->grand_total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="actions">
            <a href="{{ route('sales.download', $sale->id) }}" class="btn btn-primary">
                <i class="fas fa-download"></i> Download Invoice PDF
            </a>
            <a href="{{ route('sales.challan.show', $sale->id) }}" target="_blank" class="btn btn-primary">
                <i class="fas fa-truck"></i> View Challan PDF
            </a>
            <a href="{{ route('sales.challan.download', $sale->id) }}" class="btn btn-primary">
                <i class="fas fa-download"></i> Download Challan PDF
            </a>
            <a href="{{ route('sales.create') }}" class="btn">
                <i class="fas fa-plus"></i> Create new sale
            </a>
            <a href="{{ route('sales.index') }}" class="btn">
                <i class="fas fa-list"></i> Sales history
            </a>
            <a href="{{ route('dashboard') }}" class="btn">
                <i class="fas fa-arrow-left"></i> Back to dashboard
            </a>
        </div>
    </div>
</div>
@endsection
