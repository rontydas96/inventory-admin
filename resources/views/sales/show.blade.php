<!DOCTYPE html>
<html>

<head>
    <title>{{ $sale->invoice_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            padding: 40px;
        }

        .card {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        .btn {
            padding: 10px 16px;
            background: #0f172a;
            color: #fff;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }

        .grid {
            display: flex;
            gap: 40px;
            margin: 20px 0;
        }

        .col {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            width: 320px;
            margin-left: auto;
            margin-top: 20px;
        }

        .totals td {
            border: none;
            padding: 6px 0;
        }

        h1 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Invoice {{ $sale->invoice_no }}</h1>

        <a href="{{ route('sales.index') }}" class="btn">Back to Sales</a>
        <a href="{{ route('sales.download', $sale) }}" class="btn">Download Invoice</a>
        <a href="{{ route('sales.challan.show', $sale) }}" class="btn">View Challan</a>
        <a href="{{ route('sales.challan.download', $sale) }}" class="btn">Download Challan</a>

        @if(session('success'))
            <div style="margin: 20px 0; padding: 12px 16px; border-radius: 8px; background: #ecfdf5; color: #166534;">
                {{ session('success') }}
            </div>
        @endif

        <div class="card" style="background: #f8fafc; padding: 18px; margin-top: 20px; border: 1px solid #d1d5db;">
            <form method="POST" action="{{ route('sales.payment.update', $sale) }}">
                @csrf

                <h3 style="margin-bottom: 12px;">Payment Status & Remarks</h3>

                <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:16px;">
                    <label style="display:flex; align-items:center; gap:8px; font-weight:600;">
                        <input type="radio" name="payment_status" value="pending"
                            {{ old('payment_status', $sale->payment_status ?? 'pending') === 'pending' ? 'checked' : '' }}>
                        Pending
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-weight:600;">
                        <input type="radio" name="payment_status" value="partially_paid"
                            {{ old('payment_status', $sale->payment_status) === 'partially_paid' ? 'checked' : '' }}>
                        Partially Paid
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-weight:600;">
                        <input type="radio" name="payment_status" value="full_paid"
                            {{ old('payment_status', $sale->payment_status) === 'full_paid' ? 'checked' : '' }}>
                        Full Paid
                    </label>
                </div>

                @error('payment_status')
                    <div style="color: #b91c1c; margin-bottom: 12px;">{{ $message }}</div>
                @enderror

                <div style="margin-bottom: 16px;">
                    <label for="payment_remarks" style="display:block; font-weight:600; margin-bottom:6px;">Remarks</label>
                    <textarea id="payment_remarks" name="payment_remarks" rows="4"
                        style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;">{{ old('payment_remarks', $sale->payment_remarks) }}</textarea>
                </div>

                @error('payment_remarks')
                    <div style="color: #b91c1c; margin-bottom: 12px;">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn" style="margin-top: 0;">Save Payment Status</button>
            </form>
        </div>

        <div class="grid">
            <div class="col">
                <h3>Invoice Details</h3>
                <p><strong>Invoice No:</strong> {{ $sale->invoice_no }}</p>
                <p><strong>Invoice Date:</strong> {{ optional($sale->sale_date ?? $sale->created_at)->format('d-m-Y') }}</p>
                <p><strong>PO No:</strong> {{ $sale->po_no ?: '-' }}</p>
                <p><strong>PO Date:</strong> {{ optional($sale->po_date)->format('d-m-Y') ?: '-' }}</p>
            </div>
            <div class="col">
                <h3>Delivery Details</h3>
                <p><strong>Challan No:</strong> {{ $sale->challan_no ?: '-' }}</p>
                <p><strong>Challan Date:</strong> {{ optional($sale->sale_date ?? $sale->created_at)->format('d-m-Y') }}</p>
                <p><strong>Vehicle No:</strong> {{ $sale->vehicle_no ?: '-' }}</p>
                <p><strong>E-way Bill No:</strong> {{ $sale->ewaybill_no ?: '-' }}</p>
            </div>
        </div>

        @if($sale->subject)
            <div class="grid" style="margin-top: 20px;">
                <div class="col">
                    <h3>Subject</h3>
                    <p>{{ $sale->subject }}</p>
                </div>
            </div>
        @endif

        <div class="grid" style="margin-top: 20px;">
            <div class="col">
                <h3>Customer Information</h3>

                <p><strong>Name:</strong> {{ $sale->customer_name }}</p>

                @if($sale->customer_phone)
                    <p><strong>Phone:</strong> {{ $sale->customer_phone }}</p>
                @endif

                @if($sale->customer_email)
                    <p><strong>Email:</strong> {{ $sale->customer_email }}</p>
                @endif

                @if($sale->customer_gst)
                    <p><strong>GST:</strong> {{ $sale->customer_gst }}</p>
                @endif

                @if($sale->customer_pan)
                    <p><strong>PAN:</strong> {{ $sale->customer_pan }}</p>
                @endif
            </div>

            <div class="col">
                <h3>Billing Address</h3>
                <p>{!! nl2br(e($sale->billing_address ?: '-')) !!}</p>

                <h3>Shipping Address</h3>
                <p>{!! nl2br(e($sale->shipping_address ?: 'Same as billing')) !!}</p>
            </div>
        </div>

        <h3>Items</h3>

        <table>
            <thead>
                <tr>
                    <th>Material No</th>
                    <th>Product</th>
                    <th>HSN Code</th>
                    <th>Unit</th>
                    <th class="text-right">Selling Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">CGST Rate</th>
                    <th class="text-right">CGST Amt</th>
                    <th class="text-right">SGST Rate</th>
                    <th class="text-right">SGST Amt</th>
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
                        <td class="text-right">
                            ₹{{ number_format($item->unit_price, 2) }}
                        </td>
                        <td class="text-right">
                            {{ $item->quantity }}
                        </td>
                        <td class="text-right">
                            ₹{{ number_format($amount, 2) }}
                        </td>
                        <td class="text-right">
                            {{ number_format($halfGstRate, 2) }}%
                        </td>
                        <td class="text-right">
                            ₹{{ number_format($halfGstAmount, 2) }}
                        </td>
                        <td class="text-right">
                            {{ number_format($halfGstRate, 2) }}%
                        </td>
                        <td class="text-right">
                            ₹{{ number_format($halfGstAmount, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @php
            $saleGstRate = $sale->subtotal > 0 ? ($sale->gst_amount / $sale->subtotal) * 100 : 0;
            $halfGstRate = $saleGstRate / 2;
            $halfGstAmount = $sale->gst_amount / 2;
        @endphp

        <table class="totals">
            <tr>
                <td><strong>Subtotal</strong></td>
                <td class="text-right">
                    ₹{{ number_format($sale->subtotal, 2) }}
                </td>
            </tr>
            <tr>
                <td><strong>GST</strong></td>
                <td class="text-right">
                    ₹{{ number_format($sale->gst_amount, 2) }}
                </td>
            </tr>
            <tr>
                <td><strong>CGST ({{ number_format($halfGstRate, 2) }}%)</strong></td>
                <td class="text-right">
                    ₹{{ number_format($halfGstAmount, 2) }}
                </td>
            </tr>
            <tr>
                <td><strong>SGST ({{ number_format($halfGstRate, 2) }}%)</strong></td>
                <td class="text-right">
                    ₹{{ number_format($halfGstAmount, 2) }}
                </td>
            </tr>
            <tr>
                <td><strong>Grand Total</strong></td>
                <td class="text-right">
                    <strong>₹{{ number_format($sale->grand_total, 2) }}</strong>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>