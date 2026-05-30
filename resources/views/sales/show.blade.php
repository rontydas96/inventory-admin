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

        <p>
            <strong>Date:</strong>
            {{ $sale->created_at->format('d-m-Y H:i') }}
        </p>

        <div class="grid">
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
                    <th class="text-right">Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                    <tr>
                        <td>{{ $item->material_code }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ optional($item->product)->hsn_code ?? $item->hsn_code }}</td>
                        <td class="text-right">
                            ₹{{ number_format($item->unit_price, 2) }}
                        </td>
                        <td class="text-right">
                            {{ $item->quantity }}
                        </td>
                        <td class="text-right">
                            ₹{{ number_format($item->line_total, 2) }}
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