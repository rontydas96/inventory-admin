<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Challan - {{ $sale->challan_no ?: $sale->invoice_no }}</title>
  <style>
    @page { size: A4 portrait; margin: 12mm; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { width: 100%; min-height: 100%; }
    body { font-family: 'DejaVu Sans', sans-serif; color: #111; background: #fff; padding: 0; }
    .page { width: auto; max-width: 100%; margin: 0 auto; padding: 10px; border: 1px solid #d4d4d4; }
    .header, .customer, .footer { width: 100%; margin-bottom: 16px; }
    .flex { display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .brand-block { max-width: 58%; min-width: 180px; }
    .brand-name { font-size: 22px; font-weight: 700; color: #0f5c6d; margin-bottom: 6px; }
    .brand-note { font-size: 12px; color: #444; line-height: 1.4; }
    .meta-box { border: 1px solid #c8d4d7; border-radius: 6px; padding: 12px; min-width: 180px; background: #f8fbfb; }
    .meta-title { font-size: 11px; color: #556; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 8px; }
    .meta-value { font-size: 13px; color: #111; line-height: 1.5; }
    .section-title { font-size: 14px; font-weight: 700; margin-bottom: 10px; color: #0f5c6d; }
    .panel { border: 1px solid #d9dee0; border-radius: 8px; padding: 16px; background: #fbfdfa; }
    .panel p { font-size: 12px; line-height: 1.5; color: #222; word-wrap: break-word; }
    .table-wrap { width: 100%; overflow-x: auto; border: 1px solid #cdd6d8; border-radius: 8px; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; table-layout: fixed; }
    thead th { background: #f2f7f7; color: #222; padding: 10px 12px; text-align: left; border-bottom: 1px solid #cdd6d8; }
    tbody td { padding: 10px 12px; border-bottom: 1px solid #e4ebed; vertical-align: top; word-wrap: break-word; }
    tbody tr:last-child td { border-bottom: none; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .small { font-size: 11px; color: #555; }
    .footer-grid { display: flex; justify-content: space-between; gap: 16px; margin-top: 20px; flex-wrap: wrap; }
    .footer-card { flex: 1 1 220px; border: 1px solid #dcdfe1; border-radius: 8px; padding: 14px; background: #fafcfc; }
    .footer-card strong { display: block; margin-bottom: 8px; font-size: 13px; }
    .signature { min-height: 70px; border-top: 1px solid #cdd6d8; margin-top: 28px; padding-top: 14px; font-size: 12px; color: #444; }
    @media print {
      body { padding: 0; }
      .page { border: none; box-shadow: none; width: auto; max-width: 100%; padding: 0; }
      .flex { gap: 8px; }
      .table-wrap { border: none; }
      table { font-size: 11px; }
      .brand-name { font-size: 20px; }
      .meta-box, .panel, .footer-card { page-break-inside: avoid; }
    }
  </style>
</head>
<body>
  <div class="page">
    <div class="header flex">
      <div class="brand-block">
        <div class="brand-name">{{ $setting->brand_name ?: 'Company Name' }}</div>
        <div class="brand-note">
          {!! nl2br(e($setting->address ?: '')) !!}
        </div>
        @if($setting->phone || $setting->email)
          <div class="brand-note" style="margin-top: 10px;">
            @if($setting->phone)<strong>Phone:</strong> {{ $setting->phone }}@endif
            @if($setting->phone && $setting->email)<span> · </span>@endif
            @if($setting->email)<strong>Email:</strong> {{ $setting->email }}@endif
          </div>
        @endif
        @if($setting->gst_number)
          <div class="brand-note" style="margin-top: 6px;"><strong>GSTIN:</strong> {{ $setting->gst_number }}</div>
        @endif
      </div>

      <div class="meta-box">
        <div class="meta-title">Delivery Challan</div>
        <div class="meta-value">
          <strong>Challan No:</strong><br>
          {{ $sale->challan_no ?: 'N/A' }}
        </div>
        <div class="meta-value" style="margin-top: 10px;">
          <strong>Invoice No:</strong><br>
          {{ $sale->invoice_no }}
        </div>
        <div class="meta-value" style="margin-top: 10px;">
          <strong>Date:</strong><br>
          {{ $sale->created_at->format('d-m-Y') }}
        </div>
      </div>
    </div>

    <div class="customer flex" style="gap: 14px;">
      <div class="panel" style="flex: 2;">
        <div class="section-title">Consignee / Ship To</div>
        <p>{!! nl2br(e($sale->shipping_address ?: $sale->billing_address ?: '-')) !!}</p>
        @if($sale->customer_name)
          <p class="small" style="margin-top: 12px;"><strong>Customer:</strong> {{ $sale->customer_name }}</p>
        @endif
        @if($sale->customer_gst)
          <p class="small"><strong>Buyer GSTIN:</strong> {{ $sale->customer_gst }}</p>
        @endif
      </div>

      <div class="panel" style="flex: 1;">
        <div class="section-title">Shipment Details</div>
        <p><strong>PO No:</strong> {{ $sale->po_no ?: 'N/A' }}</p>
        <p><strong>Vehicle No:</strong> {{ $sale->vehicle_no ?: 'N/A' }}</p>
        <p><strong>Ewaybill No:</strong> {{ $sale->ewaybill_no ?: 'N/A' }}</p>
      </div>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th class="text-center" style="width: 6%;">Sr.</th>
            <th style="width: 20%;">Material No</th>
            <th>Description</th>
            <th class="text-center" style="width: 12%;">Unit</th>
            <th class="text-right" style="width: 12%;">Quantity</th>
          </tr>
        </thead>
        <tbody>
          @foreach($sale->items as $index => $item)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td>{{ $item->material_code }}</td>
              <td>{{ $item->product_name }}</td>
              <td class="text-center">{{ optional($item->product)->unit ?: 'PCS' }}</td>
              <td class="text-right">{{ $item->quantity }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="footer-grid">
      <div class="footer-card">
        <strong>Supplier</strong>
        <div>{{ $setting->brand_name ?: 'Company Name' }}</div>
        <div class="small">{{ $setting->address ?: '' }}</div>
        @if($setting->gst_number)
          <div class="small">GSTIN: {{ $setting->gst_number }}</div>
        @endif
      </div>
      <div class="footer-card">
        <strong>Notes</strong>
        <div class="small">
          This challan is generated for goods dispatched against the above invoice.
        </div>
      </div>
    </div>

    <div class="signature">
      <strong>Receiver's Signature</strong>
      <div style="margin-top: 24px;">&nbsp;</div>
    </div>
  </div>
</body>
</html>
