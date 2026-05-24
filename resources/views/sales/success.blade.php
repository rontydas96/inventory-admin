<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $sale->invoice_no }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap"
    rel="stylesheet">
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --teal-50: #E1F5EE;
      --teal-100: #9FE1CB;
      --teal-400: #1D9E75;
      --teal-600: #0F6E56;
      --teal-800: #085041;
      --teal-900: #04342C;
      --gray-50: #F7F7F5;
      --gray-100: #EDEDE9;
      --gray-200: #D5D4CF;
      --gray-500: #888780;
      --gray-700: #444441;
      --gray-900: #1A1A18;
      --radius-sm: 6px;
      --radius-md: 10px;
      --radius-lg: 14px;
      --shadow-card: 0 1px 3px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.06);
    }

    body {
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      background: var(--gray-50);
      color: var(--gray-900);
      line-height: 1.5;
      min-height: 100vh;
      padding: 2rem 1rem;
    }

    .container {
      max-width: 860px;
      margin: 0 auto;
    }

    /* ── CARD ── */
    .card {
      background: #fff;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-card);
      border: 1px solid var(--gray-100);
      overflow: hidden;
    }

    /* ── SUCCESS HEADER ── */
    .success-header {
      background: var(--teal-50);
      border-bottom: 1px solid var(--teal-100);
      padding: 1.25rem 1.75rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .success-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .success-icon {
      width: 38px;
      height: 38px;
      background: var(--teal-600);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .success-icon svg {
      width: 18px;
      height: 18px;
      stroke: var(--teal-50);
      stroke-width: 2.5;
      fill: none;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .success-title {
      font-size: 15px;
      font-weight: 600;
      color: var(--teal-800);
      margin-bottom: 2px;
    }

    .success-sub {
      font-size: 12.5px;
      color: var(--teal-600);
    }

    .invoice-badge {
      background: var(--teal-800);
      color: var(--teal-100);
      font-size: 12px;
      font-weight: 500;
      font-family: 'DM Mono', monospace;
      padding: 5px 14px;
      border-radius: var(--radius-sm);
      white-space: nowrap;
      letter-spacing: 0.03em;
    }

    /* ── BODY ── */
    .card-body {
      padding: 1.75rem;
      display: flex;
      flex-direction: column;
      gap: 1.75rem;
    }

    /* ── SECTION ── */
    .section-label {
      font-size: 10.5px;
      font-weight: 600;
      color: var(--gray-500);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .section-label svg {
      width: 13px;
      height: 13px;
      stroke: var(--gray-500);
      stroke-width: 2;
      fill: none;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    /* ── CUSTOMER GRID ── */
    .fields-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
      gap: 8px;
    }

    .field-card {
      background: var(--gray-50);
      border: 1px solid var(--gray-100);
      border-radius: var(--radius-md);
      padding: 10px 13px;
    }

    .field-card.full-width {
      grid-column: 1 / -1;
    }

    .field-label {
      font-size: 11px;
      color: var(--gray-500);
      margin-bottom: 3px;
    }

    .field-value {
      font-size: 13.5px;
      font-weight: 500;
      color: var(--gray-900);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .field-value.wrap {
      white-space: normal;
    }

    /* ── DIVIDER ── */
    .divider {
      height: 1px;
      background: var(--gray-100);
    }

    /* ── PRODUCTS TABLE ── */
    .table-wrap {
      border-radius: var(--radius-md);
      border: 1px solid var(--gray-100);
      overflow: hidden;
      overflow-x: auto;
    }

    table.products {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
      min-width: 560px;
    }

    table.products thead tr {
      background: var(--gray-50);
    }

    table.products th {
      font-size: 10.5px;
      font-weight: 600;
      color: var(--gray-500);
      text-transform: uppercase;
      letter-spacing: 0.07em;
      padding: 10px 14px;
      border-bottom: 1px solid var(--gray-100);
      white-space: nowrap;
      text-align: left;
    }

    table.products th.r,
    table.products td.r {
      text-align: right;
    }

    table.products th.c,
    table.products td.c {
      text-align: center;
    }

    table.products td {
      padding: 11px 14px;
      border-bottom: 1px solid var(--gray-100);
      color: var(--gray-900);
      vertical-align: middle;
    }

    table.products tbody tr:last-child td {
      border-bottom: none;
    }

    table.products tbody tr:nth-child(even) td {
      background: #FAFAF8;
    }

    .sku-cell, .hsn-cell {
      font-family: 'DM Mono', monospace;
      font-size: 11.5px;
      color: var(--gray-500);
    }

    .product-name {
      font-weight: 500;
    }

    /* ── TOTALS ── */
    .totals-row {
      display: flex;
      justify-content: flex-end;
    }

    .totals-card {
      background: var(--gray-50);
      border: 1px solid var(--gray-100);
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
      border-bottom: 1px solid var(--gray-100);
    }

    .total-line:last-child {
      border-bottom: none;
      background: var(--teal-800);
      color: var(--teal-50);
      font-size: 14.5px;
      font-weight: 600;
      padding: 13px 16px;
    }

    .total-line-label {
      color: var(--gray-500);
      font-size: 13px;
    }

    .total-line-value {
      font-weight: 500;
      font-family: 'DM Mono', monospace;
      font-size: 13px;
    }

    .total-line:last-child .total-line-label,
    .total-line:last-child .total-line-value {
      color: var(--teal-50);
      font-size: 14px;
    }

    /* ── ACTIONS ── */
    .actions {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 9px 18px;
      border-radius: var(--radius-sm);
      font-family: 'DM Sans', sans-serif;
      font-size: 13.5px;
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.15s ease;
      border: 1px solid var(--gray-200);
      background: #fff;
      color: var(--gray-900);
    }

    .btn:hover {
      background: var(--gray-50);
      border-color: var(--gray-200);
    }

    .btn svg {
      width: 15px;
      height: 15px;
      stroke: currentColor;
      stroke-width: 2;
      fill: none;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .btn-primary {
      background: var(--teal-600);
      color: var(--teal-50);
      border-color: var(--teal-600);
    }

    .btn-primary:hover {
      background: var(--teal-800);
      border-color: var(--teal-800);
    }

    /* ── PRINT ── */
    @media print {
      body {
        background: white;
        padding: 0;
      }

      .card {
        box-shadow: none;
        border: none;
      }

      .actions {
        display: none;
      }
    }

    @media (max-width: 600px) {
      .card-body {
        padding: 1.25rem;
      }

      .success-header {
        padding: 1rem 1.25rem;
      }

      .fields-grid {
        grid-template-columns: 1fr 1fr;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card">

      <!-- Success Header -->
      <div class="success-header">
        <div class="success-left">
          <div class="success-icon">
            <svg viewBox="0 0 24 24">
              <polyline points="20 6 9 17 4 12" />
            </svg>
          </div>
          <div>
            <p class="success-title">Sale completed successfully</p>
            <p class="success-sub">Invoice No: <strong>{{ $sale->invoice_no }}</strong></p>
          </div>
        </div>
        <span class="invoice-badge">{{ $sale->invoice_no }}</span>
      </div>

      <div class="card-body">

        <!-- Customer Details -->
        <div>
          <p class="section-label">
            <svg viewBox="0 0 24 24">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
              <circle cx="12" cy="7" r="4" />
            </svg>
            Customer details
          </p>
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

        <!-- Products -->
        <div>
          <p class="section-label">
            <svg viewBox="0 0 24 24">
              <path
                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
            </svg>
            Products
          </p>
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
                    <td class="hsn-cell">{{ $item->hsn_code }}</td>
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

        <!-- Totals -->
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

        <!-- Actions -->
        <div class="actions">
          <a href="{{ route('sales.download', $sale->id) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
              <polyline points="7 10 12 15 17 10" />
              <line x1="12" y1="15" x2="12" y2="3" />
            </svg>
            Download Invoice PDF
          </a>
          <a href="{{ route('sales.create') }}" class="btn">
            <svg viewBox="0 0 24 24">
              <line x1="12" y1="5" x2="12" y2="19" />
              <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Create new sale
          </a>
          <a href="{{ route('sales.index') }}" class="btn">
            <svg viewBox="0 0 24 24">
              <line x1="8" y1="6" x2="21" y2="6" />
              <line x1="8" y1="12" x2="21" y2="12" />
              <line x1="8" y1="18" x2="21" y2="18" />
              <line x1="3" y1="6" x2="3.01" y2="6" />
              <line x1="3" y1="12" x2="3.01" y2="12" />
              <line x1="3" y1="18" x2="3.01" y2="18" />
            </svg>
            Sales history
          </a>
        </div>

      </div>
    </div>
  </div>
</body>

</html>