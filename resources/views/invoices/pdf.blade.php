<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GST Tax Invoice - {{ $sale->invoice_no }}</title>
  <style>
    @page {
      size: A4 portrait;
      margin: 6mm 6mm 6mm 6mm;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 8.5pt;
      color: #1a1a1a;
      background: #d8e8ea;
      margin: 0;
      padding: 10px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ══ Invoice Wrapper ══ */
    .invoice-wrapper {
      width: 100%;
      min-height: 270mm;
      background: #ffffff;
      border: 1.5px solid #999;
      overflow: hidden;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ══ HEADER ══ */
    .header-table {
      width: 100%;
      border-collapse: collapse;
      border-bottom: 1.5px solid #1a1a1a;
    }

    .header-left-cell {
      width: 60%;
      padding: 8px 0 8px 10px;
      vertical-align: middle;
      background: #ffffff;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .header-right-cell {
      width: 40%;
      vertical-align: top;
      background: #0d7b78;
      padding: 8px 10px 6px 12px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .logo-company-table {
      width: 100%;
      border-collapse: collapse;
    }

    .logo-td {
      width: 72px;
      vertical-align: middle;
      padding-right: 8px;
    }

    .logo-circle {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      border: 2px solid #0d7b78;
      background: #d0f0ef;
      text-align: center;
      vertical-align: middle;
      overflow: hidden;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .logo-circle img {
      max-width: 54px;
      max-height: 54px;
    }

    .company-td {
      vertical-align: middle;
    }

    .company-name {
      font-size: 16pt;
      font-weight: 800;
      color: #0d7b78;
      line-height: 1.1;
      letter-spacing: 0.4px;
      text-transform: uppercase;
    }

    .company-sub1 {
      font-size: 7.5pt;
      color: #555;
      font-weight: 600;
      display: block;
      margin-top: 2px;
    }

    .company-sub2 {
      font-size: 7pt;
      color: #888;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.4px;
      display: block;
      margin-top: 1px;
    }

    .gst-pan-box {
      color: #ffffff;
      font-size: 7.5pt;
      font-weight: 700;
      line-height: 1.8;
      text-align: right;
    }

    .gst-label {
      color: #c8f0ee;
      font-weight: 600;
    }

    .proprietor-line {
      font-size: 9pt;
      font-weight: 700;
      color: #ffffff;
      font-style: italic;
      text-align: right;
      margin-top: 6px;
    }

    .prop-label {
      color: #f5d87a;
      font-style: normal;
      font-weight: 600;
    }

    /* ══ ADDRESS BAND ══ */
    .address-band {
      background: #fdf3cb;
      border-bottom: 1.5px solid #1a1a1a;
      text-align: center;
      padding: 4px 10px;
      font-size: 8.5pt;
      font-weight: 700;
      color: #c0392b;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ══ TITLE BAND ══ */
    .title-band {
      text-align: center;
      padding: 6px 0;
      border-bottom: 1.5px solid #1a1a1a;
      font-weight: 800;
      font-size: 11pt;
      letter-spacing: 3px;
      background: #f4fbfb;
      color: #1a1a1a;
      text-transform: uppercase;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ══ DETAILS GRID ══ */
    .details-table {
      width: 100%;
      border-collapse: collapse;
      border-bottom: 1px solid #1a1a1a;
    }

    .details-table td {
      vertical-align: top;
      /* border-right: 1.5px solid #1a1a1a; */
      padding: 0;
    }

    .dt-td{
      border-right: 1px solid #1a1a1a;
    }

    .details-table td:last-child {
      border-right: none;
    }

    .col-header {
      font-weight: 800;
      font-size: 8pt;
      text-align: center;
      color: #ffffff;
      background: #0d7b78;
      padding: 4px 4px;
      letter-spacing: 0.2px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .col-inner {
      padding: 6px 7px;
      font-size: 8pt;
      line-height: 1.45;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
    }

    .info-label {
      font-weight: 700;
      width: 50px;
      color: #065f5d;
      font-size: 8pt;
      white-space: nowrap;
      padding-right: 3px;
      vertical-align: top;
      padding-bottom: 2px;
    }

    .info-val {
      color: #1a1a1a;
      font-size: 8pt;
      vertical-align: top;
      padding-bottom: 2px;
    }

    /* Meta column (3rd) */
    .meta-inner {
      padding: 6px 8px 6px 8px;
      font-size: 8pt;
      background: #f4fbfb;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .meta-table {
      width: 100%;
      border-collapse: collapse;
    }

    .meta-label {
      font-weight: 700;
      width: 82px;
      color: #065f5d;
      font-size: 8pt;
      white-space: nowrap;
      vertical-align: top;
      padding-bottom: 3px;
    }

    .meta-sep {
      width: 8px;
      font-weight: 700;
      color: #065f5d;
      vertical-align: top;
      padding-bottom: 3px;
    }

    .meta-val {
      font-weight: 700;
      color: #1a1a1a;
      font-size: 8pt;
      vertical-align: top;
      padding-bottom: 3px;
    }

    .po-badge {
      background: #d0f0ef;
      border: 1px solid #0d7b78;
      border-radius: 2px;
      padding: 0 4px;
      font-weight: 800;
      color: #065f5d;
      font-size: 8pt;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ══ SUBJECT + REF ══ */
    .subref-table {
      width: 100%;
      border-collapse: collapse;
      border-bottom: 1.5px solid #1a1a1a;
    }

    .subref-table td {
      vertical-align: top;
      padding: 5px 7px;
      font-size: 8pt;
      line-height: 1.5;
    }

    .subject-td {
      width: 64%;
      border-right: 1.5px solid #1a1a1a;
      background: #f4fbfb;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .subject-label {
      font-weight: 800;
      color: #0d7b78;
      margin-right: 3px;
    }

    .ref-td {
      width: 36%;
      background: #fafcfc;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .ref-inner-table {
      width: 100%;
      border-collapse: collapse;
    }

    .ref-label {
      font-weight: 700;
      width: 90px;
      color: #065f5d;
      font-size: 7.5pt;
      white-space: nowrap;
      vertical-align: top;
      padding-bottom: 2px;
    }

    .ref-sep {
      width: 8px;
      color: #065f5d;
      font-weight: 700;
      vertical-align: top;
    }

    .ref-val {
      font-weight: 600;
      font-size: 7.5pt;
      color: #1a1a1a;
      vertical-align: top;
    }

    /* ══ PRODUCTS TABLE ══ */
    .products-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 7.5pt;
      border-bottom: 1.5px solid #1a1a1a;
    }

    .products-table th,
    .products-table td {
      border: 1px solid #aec8c8;
      padding: 4px 3px;
      text-align: center;
      vertical-align: middle;
    }

    .products-table td.td-left {
      text-align: left;
      padding-left: 4px;
    }

    .products-table td.td-right {
      text-align: right;
      padding-right: 4px;
    }

    .th-main {
      font-weight: 800;
      font-size: 7.5pt;
      background: #0d7b78;
      color: #ffffff;
      border-color: #076260;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .th-sub {
      font-weight: 700;
      font-size: 7pt;
      background: #0e8a88;
      color: #e0f8f7;
      border-color: #076260;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .section-title-row td {
      background: #e6f7f7;
      font-weight: 800;
      font-size: 7.5pt;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      padding: 3px;
      color: #065f5d;
      text-align: center;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .desc-cell {
      font-style: italic;
      font-weight: 600;
      color: #1a1a1a;
      text-align: left;
      padding-left: 4px;
    }

    .row-odd td {
      background: #f7fdfd;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .spacer-row td {
      height: 6px;
      border: 1px solid #aec8c8;
      background: #fafcfc;
    }

    .total-row td {
      font-weight: 800;
      font-size: 8pt;
      background: #eef8f8;
      color: #065f5d;
      border-top: 1.5px solid #1a1a1a;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* Column widths for the products table (12 cols) */
    .col-sl   { width: 3.5%; }
    .col-desc { width: 24%; }
    .col-mat  { width: 7%; }
    .col-hsn  { width: 7%; }
    .col-unit { width: 5%; }
    .col-rate { width: 8%; }
    .col-qty  { width: 5.5%; }
    .col-tot  { width: 9.5%; }
    .col-cr   { width: 4%; }
    .col-ca   { width: 8.5%; }
    .col-sr   { width: 4%; }
    .col-sa   { width: 8.5%; }

    /* ══ BOTTOM GRID ══ */
    .bottom-table {
      width: 100%;
      border-collapse: collapse;
      border-bottom: 1.5px solid #1a1a1a;
    }

    .bottom-left-td {
      width: 64%;
      vertical-align: top;
      border-right: 1.5px solid #1a1a1a;
    }

    .bank-box {
      padding: 7px 9px;
      font-size: 7.5pt;
      line-height: 1.55;
      background: #fafefe;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .bank-bold {
      font-weight: 700;
      color: #065f5d;
    }

    .bank-note {
      font-style: italic;
      margin-top: 4px;
      line-height: 1.4;
      font-weight: 500;
      color: #666;
      border-top: 1px dashed #c0d0d0;
      padding-top: 4px;
      font-size: 7pt;
    }

    .words-box {
      border-top: 1.5px solid #1a1a1a;
      padding: 6px 9px;
      font-size: 8pt;
      background: #fdf5d0;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .words-label {
      font-weight: 800;
      text-decoration: underline;
      margin-bottom: 2px;
      color: #065f5d;
    }

    .words-val {
      font-weight: 600;
      color: #2a2a2a;
      font-style: italic;
    }

    /* Cost Summary (right) */
    .cost-td {
      width: 36%;
      vertical-align: top;
    }

    .cost-title {
      text-align: center;
      padding: 5px 0;
      font-weight: 800;
      font-size: 8pt;
      letter-spacing: 1.2px;
      background: #0d7b78;
      color: #ffffff;
      text-transform: uppercase;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .cost-inner-table {
      width: 100%;
      border-collapse: collapse;
    }

    .cost-inner-table tr td {
      padding: 8px 7px;
      font-size: 8pt;
      border-bottom: 1px solid #d0e4e4;
    }

    .cost-lbl {
      font-weight: 600;
      color: #2a2a2a;
    }

    .cost-val {
      font-weight: 800;
      color: #065f5d;
      text-align: right;
      white-space: nowrap;
      width: 80px;
    }

    .cost-row-1 { background: #fafcfc; }
    .cost-row-2 { background: #f4fbfb; }
    .cost-row-3 { background: #eef8f8; }
    .cost-row-total {
      background: #d0f0ef;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .cost-row-total td {
      font-weight: 800 !important;
      font-size: 9pt !important;
      color: #065f5d !important;
      border-bottom: none !important;
    }

    /* ══ FOOTER ══ */
    .footer-table {
      width: 100%;
      border-collapse: collapse;
    }

    .footer-contact-td {
      width: 60%;
      background: #065f5d;
      padding: 8px 14px;
      color: #ffffff;
      font-size: 8.5pt;
      font-weight: 600;
      line-height: 1.7;
      vertical-align: middle;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .contact-label {
      font-weight: 700;
      color: #ffe082;
      margin-right: 4px;
    }

    .footer-sig-td {
      width: 40%;
      vertical-align: bottom;
      text-align: center;
      padding: 10px 8px 8px 8px;
      font-size: 8.5pt;
      font-weight: 800;
      color: #065f5d;
      border-left: 1.5px solid #d0e0e0;
    }

    /* ══ PRINT ══ */
    @media print {
      html, body {
        width: 210mm;
        margin: 0;
        padding: 0;
        background: #ffffff;
      }

      body {
        padding: 0;
      }

      .invoice-wrapper {
        width: 100%;
        border: 1.5px solid #999;
        box-shadow: none;
      }

      .header-right-cell,
      .col-header,
      .address-band,
      .title-band,
      .th-main,
      .th-sub,
      .section-title-row td,
      .total-row td,
      .bank-box,
      .words-box,
      .cost-title,
      .cost-row-total,
      .footer-contact-td,
      .meta-inner,
      .subject-td,
      .ref-td,
      .logo-circle {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
    }
  </style>
</head>

<body>

  @php
      if (!function_exists('numberToWords')) {
          function numberToWords($number)
          {
              $words = [0=>'zero',1=>'one',2=>'two',3=>'three',4=>'four',5=>'five',6=>'six',7=>'seven',8=>'eight',9=>'nine',10=>'ten',11=>'eleven',12=>'twelve',13=>'thirteen',14=>'fourteen',15=>'fifteen',16=>'sixteen',17=>'seventeen',18=>'eighteen',19=>'nineteen',20=>'twenty',30=>'thirty',40=>'forty',50=>'fifty',60=>'sixty',70=>'seventy',80=>'eighty',90=>'ninety'];
              $units = [10000000=>'crore',100000=>'lakh',1000=>'thousand',100=>'hundred'];
              if ($number < 21) return $words[$number];
              if ($number < 100) {
                  $tens = floor($number/10)*10;
                  $rem = $number%10;
                  return $words[$tens].($rem?' '.$words[$rem]:'');
              }
              foreach ($units as $value=>$label) {
                  if ($number>=$value) {
                      $count=floor($number/$value);
                      $rem=$number%$value;
                      $result=numberToWords($count).' '.$label;
                      if ($rem>0) $result.=($value==100?' and ':' ').numberToWords($rem);
                      return $result;
                  }
              }
              return '';
          }
      }
  @endphp

  @php
      $logoPath = !empty(optional($setting)->logo) ? public_path('storage/' . optional($setting)->logo) : null;
      if ($logoPath) { $logoPath = str_replace('\\', '/', $logoPath); }
  @endphp

  <div class="invoice-wrapper">

    <!-- ══ HEADER ══ -->
    <table class="header-table">
      <tr>
        <!-- Left: Logo + Company -->
        <td class="header-left-cell">
          <table class="logo-company-table">
            <tr>
              <td class="logo-td">
                <table style="width:64px; height:64px; border-radius:50%; border:2px solid #0d7b78; background:#d0f0ef; -webkit-print-color-adjust:exact; print-color-adjust:exact;">
                  <tr>
                    <td style="text-align:center; vertical-align:middle;">
                      @if(!empty(optional($setting)->logo) && $logoPath && file_exists($logoPath))
                        <img src="{{ $logoPath }}" style="max-width:54px; max-height:54px;" alt="Logo">
                      @else
                        <svg width="48" height="48" viewBox="0 0 100 100">
                          <circle cx="50" cy="50" r="44" stroke="#0d7b78" stroke-width="3.5" fill="none"/>
                          <circle cx="50" cy="50" r="33" stroke="#0d7b78" stroke-width="2" fill="none"/>
                          <circle cx="50" cy="50" r="19" stroke="#0d7b78" stroke-width="1.5" fill="none"/>
                          <path d="M50 6 L50 94" stroke="#0d7b78" stroke-width="2.5"/>
                          <path d="M6 50 L94 50" stroke="#0d7b78" stroke-width="2.5"/>
                          <path d="M18 18 L82 82" stroke="#0d7b78" stroke-width="1.8"/>
                          <path d="M18 82 L82 18" stroke="#0d7b78" stroke-width="1.8"/>
                          <circle cx="50" cy="50" r="5" fill="#f39223"/>
                        </svg>
                      @endif
                    </td>
                  </tr>
                </table>
              </td>
              <td class="company-td">
                <div class="company-name">{{ $setting->brand_name ?? 'Your Company Name' }}</div>
                <span class="company-sub1">{{ $setting->company_description ?? '' }}</span>
                <span class="company-sub2">Govt. Contractor &amp; General Order Supplier</span>
              </td>
            </tr>
          </table>
        </td>
        <!-- Right: Teal block with GST/PAN + Proprietor -->
        <td class="header-right-cell">
          <div class="gst-pan-box">
            <span class="gst-label">GSTIN No</span> &nbsp;: &nbsp;{{ $setting->gst_number ?? '-' }}<br>
            <span class="gst-label">PAN No</span> &nbsp;&nbsp; - &nbsp;&nbsp; {{ $setting->pan_number ?? '-' }}<br>
            @if(!empty($setting->udyam_no))
            <span class="gst-label">Udyam No</span> &nbsp;- &nbsp;{{ $setting->udyam_no }}<br>
            @endif
            @if(!empty($setting->vendor_code))
            <span class="gst-label">Vendor Code</span> - {{ $setting->vendor_code }}<br>
            @endif
          </div>
          <div class="proprietor-line">
            <span class="prop-label">Prop:</span> {{ $setting->proprietor_name ?? '' }}
          </div>
        </td>
      </tr>
    </table>

    <!-- ══ ADDRESS BAND ══ -->
    <div class="address-band">&#9726; {{ $setting->address ?? '' }} &#9726;</div>

    <!-- ══ TITLE BAND ══ -->
    <div class="title-band">GST TAX INVOICE</div>

    <!-- ══ DETAILS 3-COLUMN ══ -->
    <table class="details-table">
      <tr>
        <!-- Bill To -->
        <td style="width:32%;" class="dt-td">
          <div class="col-header">Details of the Receiver (Bill to)</div>
          <div class="col-inner">
            <table class="info-table">
              <tr>
                <td class="info-label">Name:</td>
                <td class="info-val" style="font-weight:700;">{{ $sale->customer_name }}</td>
              </tr>
              <tr>
                <td class="info-label" style="vertical-align:top;">Address:</td>
                <td class="info-val">
                  <strong>{!! nl2br(e($sale->billing_address ?: '')) !!}</strong>
                  @if($sale->customer_email)<br>Email: {{ $sale->customer_email }}@endif
                  @if($sale->customer_phone) &nbsp; Tel: {{ $sale->customer_phone }}@endif
                </td>
              </tr>
              <tr>
                <td class="info-label">GST/UID:</td>
                <td class="info-val" style="font-weight:700;">@if($sale->customer_gst){{ $sale->customer_gst }}@endif</td>
              </tr>
              <tr>
                <td class="info-label">PAN :</td>
                <td class="info-val" style="font-weight:700;">@if($sale->customer_pan){{ $sale->customer_pan }}@endif</td>
              </tr>
            </table>
          </div>
        </td>

        <!-- Shipped To -->
        <td style="width:32%;" class="dt-td">
          <div class="col-header">Details of the Consignee (Shipped to)</div>
          <div class="col-inner">
            <table class="info-table">
              <tr>
                <td class="info-label">Name:</td>
                <td class="info-val" style="font-weight:700;">{{ $sale->customer_name }}</td>
              </tr>
              <tr>
                <td class="info-label" style="vertical-align:top;">Address:</td>
                <td class="info-val">
                  <strong>{!! nl2br(e($sale->billing_address ?: '')) !!}</strong>
                  @if($sale->customer_email)<br>Email: {{ $sale->customer_email }}@endif
                  @if($sale->customer_phone) &nbsp; Tel: {{ $sale->customer_phone }}@endif
                </td>
              </tr>
              <tr>
                <td class="info-label">GST/UID:</td>
                <td class="info-val" style="font-weight:700;">@if($sale->customer_gst){{ $sale->customer_gst }}@endif</td>
              </tr>
              <tr>
                <td class="info-label">PAN :</td>
                <td class="info-val" style="font-weight:700;">@if($sale->customer_pan){{ $sale->customer_pan }}@endif</td>
              </tr>
            </table>
          </div>
        </td>

        <!-- Invoice Meta -->
        <td style="width:36%; border-right:none;">
          <div class="meta-inner">
            <table class="meta-table">
              <tr>
                <td class="meta-label">Invoice No.</td>
                <td class="meta-sep">:</td>
                <td class="meta-val">{{ $sale->invoice_no }}</td>
              </tr>
              <tr>
                <td class="meta-label">Invoice Dated</td>
                <td class="meta-sep">:</td>
                <td class="meta-val">{{ \Carbon\Carbon::parse($sale->created_at)->format('d.m.Y') }}</td>
              </tr>
              <tr>
                <td class="meta-label">PO No</td>
                <td class="meta-sep">:</td>
                <td class="meta-val"><span class="po-badge">{{ $sale->po_no ?: '-' }}</span></td>
              </tr>
              <tr>
                <td class="meta-label">PO Date</td>
                <td class="meta-sep">:</td>
                <td class="meta-val">{{ \Carbon\Carbon::parse($sale->created_at)->format('d.m.Y') }}</td>
              </tr>
              <tr>
                <td class="meta-label">Challan No</td>
                <td class="meta-sep">:</td>
                <td class="meta-val">{{ $sale->challan_no ?: '-' }}</td>
              </tr>
              <tr>
                <td class="meta-label">Challan Date</td>
                <td class="meta-sep">:</td>
                <td class="meta-val">{{ \Carbon\Carbon::parse($sale->created_at)->format('d.m.Y') }}</td>
              </tr>
              <tr>
                <td class="meta-label">Vehicle No</td>
                <td class="meta-sep">:</td>
                <td class="meta-val">{{ $sale->vehicle_no ?: '-' }}</td>
              </tr>
              <tr>
                <td class="meta-label">E-way Bill No</td>
                <td class="meta-sep">:</td>
                <td class="meta-val">{{ $sale->ewaybill_no ?: '-' }}</td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>

    <!-- ══ SUBJECT + REF ══ -->
    <table class="subref-table">
      <tr>
        <td class="subject-td">
          <span class="subject-label">Sub:</span>
          <span>{{ $sale->subject ?: 'Supply & Delivery of materials as per purchase order.' }}</span>
        </td>
        <td class="ref-td">
          <table class="ref-inner-table">
            <tr>
              <td class="ref-label">Ref: Memo No</td>
              <td class="ref-sep">:</td>
              <td class="ref-val">{{ $sale->ref_memo_no ?? '&nbsp;' }}</td>
            </tr>
            <tr>
              <td class="ref-label">Ref: Memo Date</td>
              <td class="ref-sep">:</td>
              <td class="ref-val">{{ \Carbon\Carbon::parse($sale->created_at)->format('d.m.Y') }}</td>
            </tr>
            <tr>
              <td class="ref-label">E-way Bill No</td>
              <td class="ref-sep">:</td>
              <td class="ref-val">{{ $sale->ewaybill_no ?: '&nbsp;' }}</td>
            </tr>
            <tr>
              <td class="ref-label">E-way Bill Date</td>
              <td class="ref-sep">:</td>
              <td class="ref-val">&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- ══ PRODUCTS TABLE ══ -->
    <table class="products-table">
      <thead>
        <tr>
          <th class="th-main col-sl" rowspan="2">Sl.<br>No</th>
          <th class="th-main col-desc" rowspan="2">Description of Goods</th>
          <th class="th-main col-mat" rowspan="2">SKU</th>
          <th class="th-main col-hsn" rowspan="2">HSN<br>Code</th>
          <th class="th-main col-unit" rowspan="2">Unit</th>
          <th class="th-main col-rate" rowspan="2">Rate</th>
          <th class="th-main col-qty" rowspan="2">Qty</th>
          <th class="th-main col-tot" rowspan="2">Total<br>Amount</th>
          <th class="th-main" colspan="2">CGST</th>
          <th class="th-main" colspan="2">SGST</th>
        </tr>
        <tr>
          <th class="th-sub col-cr">Rate</th>
          <th class="th-sub col-ca">Amount</th>
          <th class="th-sub col-sr">Rate</th>
          <th class="th-sub col-sa">Amount</th>
        </tr>
        <tr class="section-title-row">
          <td colspan="12">&#9665; PRODUCTS SUPPLIED &#9665;</td>
        </tr>
      </thead>
      <tbody>

        @php $subtotal = 0; @endphp

        @foreach($sale->items as $index => $item)
          @php
            $displayRate   = $item->quantity > 0 ? $item->line_total / $item->quantity : $item->unit_price;
            $rowTotal      = $item->unit_price * $item->quantity;
            $subtotal     += $rowTotal;
            $halfGstRate   = $item->gst_percentage / 2;
            $halfGstAmount = $item->gst_amount / 2;
          @endphp
          <tr class="{{ $loop->odd ? 'row-odd' : '' }}">
            <td>{{ $index + 1 }}</td>
            <td class="desc-cell">{{ $item->product_name }}</td>
            <td>{{ $item->material_code }}</td>
            <td>{{ optional($item->product)->hsn_code ?? $item->hsn_code ?? '-' }}</td>
            <td>{{ optional($item->product)->unit ?? '-' }}</td>
            <td class="td-right">&#8377;{{ number_format($displayRate, 2) }}</td>
            <td>{{ $item->quantity }}</td>
            <td class="td-right" style="font-weight:700; color:#065f5d;">&#8377;{{ number_format($rowTotal, 2) }}</td>
            <td>{{ number_format($halfGstRate, 0) }}%</td>
            <td class="td-right">&#8377;{{ number_format($halfGstAmount, 2) }}</td>
            <td>{{ number_format($halfGstRate, 0) }}%</td>
            <td class="td-right">&#8377;{{ number_format($halfGstAmount, 2) }}</td>
          </tr>
        @endforeach

        <tr class="spacer-row">
          <td colspan="12"></td>
        </tr>

        <tr class="total-row">
          <td colspan="7" class="td-right" style="padding-right:7px; letter-spacing:0.4px;">TOTAL AMOUNT (Rs.)</td>
          <td class="td-right">&#8377;{{ number_format($subtotal, 2) }}</td>
          <td></td>
          <td class="td-right">&#8377;{{ number_format($sale->gst_amount / 2, 2) }}</td>
          <td></td>
          <td class="td-right">&#8377;{{ number_format($sale->gst_amount / 2, 2) }}</td>
        </tr>

      </tbody>
    </table>

    <!-- ══ BOTTOM: Bank Details + Cost Summary ══ -->
    @php
      $invoiceGstRate     = $sale->subtotal > 0 ? ($sale->gst_amount / $sale->subtotal) * 100 : 0;
      $halfInvoiceGstRate = $invoiceGstRate / 2;
    @endphp

    <table class="bottom-table">
      <tr>
        <!-- Bank Details + Amount in Words -->
        <td class="bottom-left-td">
          <div class="bank-box">
            <div style="margin-bottom:1px;">Payment of the Invoice may be made online through NEFT / RTGS made into our Bank Account in A/C Holder</div>
            <div style="margin-bottom:1px;"><span class="bank-bold">Name: {{ $setting->brand_name ?? 'Company' }},</span></div>
            <div style="margin-bottom:1px;">Bank Name: <span class="bank-bold">{{ $setting->bank_name ?? '-' }}</span>, &nbsp; A/C No: <span class="bank-bold">{{ $setting->bank_account_no ?? '-' }}</span></div>
            <div style="margin-bottom:1px;">IFSC Code: <span class="bank-bold">{{ $setting->bank_ifsc ?? '-' }}</span></div>
            <div class="bank-note">Kindly communicate to us with the invoice details against your payments to facilitate accounting. For IT-TDS/GST-TDS deduction if any. Certificate has to be given along with the payment.</div>
          </div>
          <div class="words-box">
            <div class="words-label">Tax Amount Rupees (in words)</div>
            <div class="words-val">{{ ucwords(numberToWords((int) round($sale->grand_total))) }} Rupees and No Paise</div>
          </div>
        </td>

        <!-- Cost Summary -->
        <td class="cost-td">
          <div class="cost-title">COST SUMMARY</div>
          <table class="cost-inner-table">
            <tr class="cost-row-1">
              <td class="cost-lbl">TOTAL AMOUNT (Rs.)</td>
              <td class="cost-val">&#8377; {{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr class="cost-row-2">
              <td class="cost-lbl">GST {{ number_format($invoiceGstRate, 0) }}%</td>
              <td class="cost-val">&#8377; {{ number_format($sale->gst_amount, 2) }}</td>
            </tr>
            <tr class="cost-row-3">
              <td class="cost-lbl">TOTAL AMOUNT (Rs.)<br><small style="font-weight:600; font-size:7pt;">Including Tax</small></td>
              <td class="cost-val" style="font-size:9pt;">&#8377; {{ number_format($sale->grand_total, 2) }}</td>
            </tr>
            <tr class="cost-row-total">
              <td class="cost-lbl">Say Amount (Rs.)</td>
              <td class="cost-val">&#8377; {{ number_format($sale->grand_total, 2) }}</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- ══ FOOTER ══ -->
    <table class="footer-table">
      <tr>
        <td class="footer-contact-td">
          <div><span class="contact-label">E-Mail :</span> @if($setting->email){{ $setting->email }}@endif</div>
          <div style="margin-top:2px;"><span class="contact-label">Contact :</span> @if($setting->phone){{ $setting->phone }}@endif</div>
        </td>
        <td class="footer-sig-td">
          <div style="height:32px;"></div>
          <div>Authorised Signatory</div>
        </td>
      </tr>
    </table>

  </div><!-- /invoice-wrapper -->

</body>
</html>