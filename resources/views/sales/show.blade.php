@extends('layouts.app')

@section('title', $sale->invoice_no)

@section('styles')
<style>
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin: 20px 0; }
    .grid.three { grid-template-columns: 1fr 1fr 1fr; }
    .section-title { font-size: 16px; font-weight: 600; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; color: var(--text); }
    .section-title i { color: var(--accent); }
    .info-group { background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; padding: 18px; }
    .info-group p { margin-bottom: 8px; font-size: 14px; }
    .info-group p:last-child { margin-bottom: 0; }
    .info-group p strong { color: var(--text-muted); font-weight: 500; display: inline-block; min-width: 100px; }
    .totals-container { margin-left: auto; width: 320px; margin-top: 16px; }
    .totals-container table { margin-top: 0; }
    .totals-container td { border: none; padding: 6px 0; font-size: 14px; }
    .totals-container tr:last-child td { font-weight: 700; font-size: 16px; border-top: 2px solid var(--text); padding-top: 10px; }
    .payment-section { background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; padding: 20px; margin-top: 20px; }
    .payment-section h3 { font-size: 15px; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
    .radio-group { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 16px; }
    .radio-group label { display: flex; align-items: center; gap: 8px; font-weight: 500; font-size: 14px; cursor: pointer; }
    .radio-group input[type="radio"] { width: 16px; height: 16px; accent-color: var(--primary); }
    .payment-section textarea { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical; box-sizing: border-box; }
    .payment-section textarea:focus { outline: none; border-color: var(--accent); }
    @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } .totals-container { width: 100%; } }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-file-invoice"></i> Invoice {{ $sale->invoice_no }}</h1>
        <div style="display:flex;flex-wrap:wrap;gap:4px;">
            <a href="{{ route('sales.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Sales</a>
            <a href="{{ route('sales.download', $sale) }}" class="btn btn-accent"><i class="fas fa-download"></i> Download Invoice</a>
            <a href="{{ route('sales.challan.show', $sale) }}" class="btn btn-outline"><i class="fas fa-truck"></i> View Challan</a>
            <a href="{{ route('sales.challan.download', $sale) }}" class="btn btn-outline"><i class="fas fa-download"></i> Download Challan</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="payment-section">
        <form method="POST" action="{{ route('sales.payment.update', $sale) }}">
            @csrf
            <h3><i class="fas fa-credit-card"></i> Payment Status &amp; Remarks</h3>
            <div class="radio-group">
                <label><input type="radio" name="payment_status" value="pending" {{ old('payment_status', $sale->payment_status ?? 'pending') === 'pending' ? 'checked' : '' }}> <span class="badge" style="background:#fef3c7;color:#92400e;padding:2px 10px;border-radius:999px;font-size:12px;">Pending</span></label>
                <label><input type="radio" name="payment_status" value="partially_paid" {{ old('payment_status', $sale->payment_status) === 'partially_paid' ? 'checked' : '' }}> <span class="badge" style="background:#dbeafe;color:#1e40af;padding:2px 10px;border-radius:999px;font-size:12px;">Partially Paid</span></label>
                <label><input type="radio" name="payment_status" value="full_paid" {{ old('payment_status', $sale->payment_status) === 'full_paid' ? 'checked' : '' }}> <span class="badge" style="background:#dcfce7;color:#166534;padding:2px 10px;border-radius:999px;font-size:12px;">Full Paid</span></label>
            </div>
            @error('payment_status')<div style="color:#b91c1c;margin-bottom:12px;font-size:13px;">{{ $message }}</div>@enderror
            <div style="margin-bottom:16px;">
                <label for="payment_remarks" style="display:block;font-weight:500;margin-bottom:6px;font-size:14px;">Remarks</label>
                <textarea id="payment_remarks" name="payment_remarks" rows="3">{{ old('payment_remarks', $sale->payment_remarks) }}</textarea>
            </div>
            @error('payment_remarks')<div style="color:#b91c1c;margin-bottom:12px;font-size:13px;">{{ $message }}</div>@enderror
            <button type="submit" class="btn"><i class="fas fa-save"></i> Save Payment Status</button>
        </form>
    </div>

    <div class="grid">
        <div class="info-group">
            <div class="section-title"><i class="fas fa-info-circle"></i> Invoice Details</div>
            <p><strong>Invoice No:</strong> {{ $sale->invoice_no }}</p>
            <p><strong>Invoice Date:</strong> {{ optional($sale->sale_date ?? $sale->created_at)->format('d-m-Y') }}</p>
            <p><strong>PO No:</strong> {{ $sale->po_no ?: '-' }}</p>
            <p><strong>PO Date:</strong> {{ optional($sale->po_date)->format('d-m-Y') ?: '-' }}</p>
        </div>
        <div class="info-group">
            <div class="section-title"><i class="fas fa-truck"></i> Delivery Details</div>
            <p><strong>Challan No:</strong> {{ $sale->challan_no ?: '-' }}</p>
            <p><strong>Challan Date:</strong> {{ optional($sale->sale_date ?? $sale->created_at)->format('d-m-Y') }}</p>
            <p><strong>Vehicle No:</strong> {{ $sale->vehicle_no ?: '-' }}</p>
            <p><strong>E-way Bill No:</strong> {{ $sale->ewaybill_no ?: '-' }}</p>
        </div>
    </div>

    @if($sale->subject)
        <div class="info-group" style="margin-bottom:16px;">
            <div class="section-title"><i class="fas fa-tag"></i> Subject</div>
            <p>{{ $sale->subject }}</p>
        </div>
    @endif

    <div class="grid">
        <div class="info-group">
            <div class="section-title"><i class="fas fa-user"></i> Customer Information</div>
            <p><strong>Name:</strong> {{ $sale->customer_name }}</p>
            @if($sale->customer_phone)<p><strong>Phone:</strong> {{ $sale->customer_phone }}</p>@endif
            @if($sale->customer_email)<p><strong>Email:</strong> {{ $sale->customer_email }}</p>@endif
            @if($sale->customer_gst)<p><strong>GST:</strong> {{ $sale->customer_gst }}</p>@endif
            @if($sale->customer_pan)<p><strong>PAN:</strong> {{ $sale->customer_pan }}</p>@endif
        </div>
        <div class="info-group">
            <div class="section-title"><i class="fas fa-map-marker-alt"></i> Addresses</div>
            <p><strong>Billing:</strong><br>{{ $sale->billing_address ?: '-' }}</p>
            <p style="margin-top:10px;"><strong>Shipping:</strong><br>{{ $sale->shipping_address ?: 'Same as billing' }}</p>
        </div>
    </div>

    <div class="section-title" style="margin-top:24px;"><i class="fas fa-shopping-bag"></i> Items</div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Material No</th><th>Product</th><th>HSN Code</th><th>Unit</th>
                    <th class="text-right">Selling Price</th><th class="text-right">Qty</th>
                    <th class="text-right">Amount</th><th class="text-right">CGST Rate</th>
                    <th class="text-right">CGST Amt</th><th class="text-right">SGST Rate</th><th class="text-right">SGST Amt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                    @php
                        $amount = $item->unit_price * $item->quantity;
                        $halfGstRate = $item->gst_percentage / 2;
                        $halfGstAmount = $item->gst_amount / 2;
                    @endphp
                    <tr>
                        <td>{{ $item->material_code }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ optional($item->product)->hsn_code ?? $item->hsn_code }}</td>
                        <td>{{ optional($item->product)->unit ?? '-' }}</td>
                        <td class="text-right">₹{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format($amount, 2) }}</td>
                        <td class="text-right">{{ number_format($halfGstRate, 2) }}%</td>
                        <td class="text-right">₹{{ number_format($halfGstAmount, 2) }}</td>
                        <td class="text-right">{{ number_format($halfGstRate, 2) }}%</td>
                        <td class="text-right">₹{{ number_format($halfGstAmount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @php
        $saleGstRate = $sale->subtotal > 0 ? ($sale->gst_amount / $sale->subtotal) * 100 : 0;
        $halfGstRate = $saleGstRate / 2;
        $halfGstAmount = $sale->gst_amount / 2;
    @endphp

    <div class="totals-container">
        <table>
            <tr><td><strong>Subtotal</strong></td><td class="text-right">₹{{ number_format($sale->subtotal, 2) }}</td></tr>
            <tr><td><strong>GST</strong></td><td class="text-right">₹{{ number_format($sale->gst_amount, 2) }}</td></tr>
            <tr><td><strong>CGST ({{ number_format($halfGstRate, 2) }}%)</strong></td><td class="text-right">₹{{ number_format($halfGstAmount, 2) }}</td></tr>
            <tr><td><strong>SGST ({{ number_format($halfGstRate, 2) }}%)</strong></td><td class="text-right">₹{{ number_format($halfGstAmount, 2) }}</td></tr>
            <tr><td><strong>Grand Total</strong></td><td class="text-right"><strong>₹{{ number_format($sale->grand_total, 2) }}</strong></td></tr>
        </table>
    </div>
</div>
@endsection
