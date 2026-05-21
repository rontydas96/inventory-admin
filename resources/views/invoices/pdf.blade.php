<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sale Complete - {{ $sale->invoice_no }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&family=DM+Mono:wght@400;500&family=Playfair+Display:ital,wght@1,700&display=swap"
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
            --teal-200: #5DCAA5;
            --teal-400: #1D9E75;
            --teal-600: #0F6E56;
            --teal-800: #085041;
            --teal-900: #04342C;
            --gray-50: #F7F7F5;
            --gray-100: #EDEDE9;
            --gray-200: #D5D4CF;
            --gray-400: #A8A79F;
            --gray-500: #888780;
            --gray-700: #444441;
            --gray-900: #1A1A18;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            background: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.5;
            min-height: 100vh;
            padding: 2rem 1rem 3rem;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* ── PAGE WRAPPER ── */
        .page-wrap {
            max-width: 940px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* ── SUCCESS BANNER ── */
        .success-banner {
            background: var(--teal-800);
            border-radius: var(--radius-lg);
            padding: 1.5rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .banner-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .banner-icon {
            width: 42px;
            height: 42px;
            background: var(--teal-400);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .banner-icon svg {
            width: 20px;
            height: 20px;
            stroke: #fff;
            stroke-width: 2.5;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .banner-title {
            font-size: 17px;
            font-weight: 600;
            color: var(--teal-50);
            margin-bottom: 4px;
        }

        .banner-meta {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .banner-meta-item {
            font-size: 12.5px;
            color: var(--teal-200);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .banner-meta-item strong {
            color: var(--teal-50);
            font-weight: 500;
        }

        .banner-meta-item svg {
            width: 13px;
            height: 13px;
            stroke: var(--teal-200);
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ── ACTION BAR ── */
        .action-bar {
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

        /* ── INVOICE CARD ── */
        .invoice-card {
            background: #fff;
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-100);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 6px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* ── INVOICE HEADER ── */
        .inv-header {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 1rem;
            padding: 1.75rem 2rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .inv-logo-wrap {
            display: flex;
            align-items: center;
        }

        .inv-logo {
            max-height: 72px;
            max-width: 110px;
            object-fit: contain;
        }

        .inv-logo-placeholder {
            width: 56px;
            height: 56px;
            background: var(--teal-50);
            border: 1px solid var(--teal-100);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .inv-logo-placeholder svg {
            width: 24px;
            height: 24px;
            stroke: var(--teal-600);
            stroke-width: 1.5;
            fill: none;
        }

        .inv-company-center {
            text-align: center;
        }

        .company-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 22px;
            font-weight: 600;
            color: var(--teal-600);
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .company-details {
            font-size: 11.5px;
            color: var(--gray-500);
            line-height: 1.6;
        }

        .inv-reg-info {
            text-align: right;
        }

        .reg-row {
            font-size: 12px;
            color: var(--gray-700);
            margin-bottom: 3px;
        }

        .reg-row span {
            font-size: 11px;
            color: var(--gray-400);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-right: 4px;
        }

        .reg-row strong {
            font-family: 'DM Mono', monospace;
            font-weight: 500;
        }

        /* ── INVOICE TITLE STRIP ── */
        .inv-title-strip {
            background: var(--gray-900);
            padding: 10px 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .inv-title-strip h2 {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 17px;
            font-weight: 700;
            color: var(--teal-100);
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        /* ── TWO-COLUMN SECTION ── */
        .inv-info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-bottom: 1px solid var(--gray-100);
        }

        .inv-info-col {
            padding: 1.25rem 2rem;
        }

        .inv-info-col+.inv-info-col {
            border-left: 1px solid var(--gray-100);
        }

        .info-section-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .info-section-label svg {
            width: 12px;
            height: 12px;
            stroke: var(--gray-400);
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .bill-name {
            font-size: 15px;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 5px;
        }

        .bill-detail {
            font-size: 12.5px;
            color: var(--gray-500);
            line-height: 1.7;
        }

        .bill-detail strong {
            color: var(--gray-700);
            font-weight: 500;
        }

        .meta-grid {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .meta-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            font-size: 12.5px;
        }

        .meta-label {
            font-size: 11px;
            font-weight: 500;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            min-width: 88px;
        }

        .meta-value {
            color: var(--gray-900);
            font-weight: 500;
        }

        .meta-value.mono {
            font-family: 'DM Mono', monospace;
            font-size: 12px;
        }

        /* ── SUBJECT ROW ── */
        .inv-subject-row {
            padding: 10px 2rem;
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-100);
            font-size: 12.5px;
            color: var(--gray-500);
        }

        .inv-subject-row strong {
            color: var(--gray-700);
            font-weight: 500;
        }

        /* ── PRODUCTS TABLE ── */
        .inv-table-wrap {
            overflow-x: auto;
            border-bottom: 1px solid var(--gray-100);
        }

        table.inv-products {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            min-width: 620px;
        }

        table.inv-products thead tr {
            background: var(--gray-50);
        }

        table.inv-products th {
            font-size: 10px;
            font-weight: 600;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 10px 14px;
            border-bottom: 1px solid var(--gray-100);
            white-space: nowrap;
            text-align: left;
        }

        table.inv-products th.r,
        table.inv-products td.r {
            text-align: right;
        }

        table.inv-products th.c,
        table.inv-products td.c {
            text-align: center;
        }

        table.inv-products td {
            padding: 10px 14px;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-900);
            vertical-align: middle;
        }

        table.inv-products tbody tr:last-child td {
            border-bottom: none;
        }

        table.inv-products tbody tr:hover td {
            background: #FAFAF8;
        }

        .sl-num {
            font-size: 11px;
            color: var(--gray-400);
            font-family: 'DM Mono', monospace;
        }

        .sku-pill {
            display: inline-block;
            background: var(--gray-100);
            color: var(--gray-500);
            font-family: 'DM Mono', monospace;
            font-size: 10.5px;
            padding: 2px 7px;
            border-radius: 4px;
        }

        .product-name {
            font-weight: 500;
            color: var(--gray-900);
        }

        .amount-cell {
            font-family: 'DM Mono', monospace;
            font-size: 12px;
        }

        .gst-badge {
            display: inline-block;
            background: var(--teal-50);
            color: var(--teal-600);
            font-size: 10.5px;
            font-weight: 500;
            padding: 2px 6px;
            border-radius: 4px;
        }

        /* ── BOTTOM SECTION: BANK + TOTALS ── */
        .inv-bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-bottom: 1px solid var(--gray-100);
        }

        .inv-bank-col {
            padding: 1.25rem 2rem;
            border-right: 1px solid var(--gray-100);
        }

        .bank-row {
            font-size: 12.5px;
            color: var(--gray-500);
            margin-bottom: 4px;
            display: flex;
            gap: 6px;
        }

        .bank-row span {
            font-size: 11px;
            font-weight: 500;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            min-width: 70px;
            padding-top: 1px;
        }

        .bank-row strong {
            font-family: 'DM Mono', monospace;
            font-weight: 500;
            color: var(--gray-700);
            font-size: 12px;
        }

        .inv-totals-col {
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 11px 1.75rem;
            font-size: 13px;
            border-bottom: 1px solid var(--gray-100);
        }

        .total-line:last-child {
            border-bottom: none;
        }

        .total-label {
            color: var(--gray-500);
            font-size: 12.5px;
        }

        .total-value {
            font-family: 'DM Mono', monospace;
            font-size: 12.5px;
            font-weight: 500;
        }

        .total-grand {
            background: var(--teal-800);
            padding: 14px 1.75rem;
            margin-top: auto;
        }

        .total-grand .total-label,
        .total-grand .total-value {
            color: var(--teal-50);
            font-size: 14px;
            font-weight: 600;
        }

        /* ── FOOTER: WORDS + SIGNATURE ── */
        .inv-footer-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .inv-words-col {
            padding: 1.25rem 2rem;
            border-right: 1px solid var(--gray-100);
        }

        .words-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 6px;
        }

        .words-value {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--gray-700);
            font-style: italic;
        }

        .inv-sig-col {
            padding: 1.25rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
            min-height: 100px;
        }

        .sig-for {
            font-size: 11.5px;
            color: var(--gray-500);
            text-align: right;
        }

        .sig-for strong {
            display: block;
            font-weight: 600;
            color: var(--gray-700);
            font-size: 13px;
        }

        .sig-line {
            width: 140px;
            border-top: 1.5px solid var(--gray-300, #C5C4BF);
            padding-top: 5px;
            text-align: center;
            font-size: 11px;
            color: var(--gray-500);
            font-weight: 500;
            letter-spacing: 0.03em;
            margin-top: 1rem;
        }

        /* ── PRINT STYLES ── */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .success-banner,
            .action-bar {
                display: none !important;
            }

            .invoice-card {
                box-shadow: none;
                border: none;
                border-radius: 0;
            }

            table.inv-products tbody tr:hover td {
                background: transparent;
            }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 700px) {
            .inv-header {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 0.75rem;
            }

            .inv-logo-wrap {
                justify-content: center;
            }

            .inv-reg-info {
                text-align: center;
            }

            .inv-info-row,
            .inv-bottom-row,
            .inv-footer-row {
                grid-template-columns: 1fr;
            }

            .inv-info-col+.inv-info-col,
            .inv-bank-col,
            .inv-words-col {
                border-left: none;
                border-right: none;
                border-top: 1px solid var(--gray-100);
            }

            .inv-sig-col {
                align-items: flex-start;
                border-top: 1px solid var(--gray-100);
            }

            .banner-meta {
                flex-direction: column;
                gap: 6px;
            }

            .action-bar {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    @php
        if (!function_exists('numberToWords')) {
            function numberToWords($number)
            {
                $words = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'];
                $units = [10000000 => 'crore', 100000 => 'lakh', 1000 => 'thousand', 100 => 'hundred'];
                if ($number < 21)
                    return $words[$number];
                if ($number < 100) {
                    $tens = floor($number / 10) * 10;
                    $rem = $number % 10;
                    return $words[$tens] . ($rem ? ' ' . $words[$rem] : '');
                }
                foreach ($units as $value => $label) {
                    if ($number >= $value) {
                        $count = floor($number / $value);
                        $rem = $number % $value;
                        $result = numberToWords($count) . ' ' . $label;
                        if ($rem > 0) {
                            $result .= ($value == 100 ? ' and ' : ' ') . numberToWords($rem);
                        }
                        return $result;
                    }
                }
                return '';
            }
        }
      @endphp

    <div class="page-wrap">

        <!-- Success Banner -->
        <div class="success-banner">
            <div class="banner-left">
                <div class="banner-icon">
                    <svg viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <div>
                    <p class="banner-title">Sale completed successfully</p>
                    <div class="banner-meta">
                        <span class="banner-meta-item">
                            <svg viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            <strong>{{ $sale->invoice_no }}</strong>
                        </span>
                        <span class="banner-meta-item">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            <strong>{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y') }}</strong>
                        </span>
                        <span class="banner-meta-item">
                            Grand Total: <strong>₹{{ number_format($sale->grand_total, 2) }}</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-bar">
            <a href="{{ route('sales.download', $sale->id) }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Download PDF
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

        <!-- Invoice Card -->
        <div class="invoice-card">

            <!-- Company Header -->
            <div class="inv-header">
                <div class="inv-logo-wrap">
                    @if(!empty($setting->logo))
                        <img src="{{ asset('storage/' . $setting->logo) }}" class="inv-logo" alt="Logo">
                    @else
                        <div class="inv-logo-placeholder">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="inv-company-center">
                    <div class="company-name">{{ $setting->brand_name ?? 'Your Company Name' }}</div>
                    <div class="company-details">
                        {{ $setting->address ?? '' }}<br>
                        @if($setting->phone) Phone: {{ $setting->phone }} @endif
                        @if($setting->email) &nbsp;·&nbsp; {{ $setting->email }} @endif
                    </div>
                </div>

                <div class="inv-reg-info">
                    <div class="reg-row"><span>GSTIN</span><strong>{{ $setting->gst_number ?? '-' }}</strong></div>
                    <div class="reg-row"><span>PAN</span><strong>{{ $setting->pan_number ?? '-' }}</strong></div>
                </div>
            </div>

            <!-- TAX INVOICE Title -->
            <div class="inv-title-strip">
                <h2>Tax Invoice</h2>
            </div>

            <!-- Bill To + Invoice Info -->
            <div class="inv-info-row">
                <div class="inv-info-col">
                    <p class="info-section-label">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Bill to
                    </p>
                    <p class="bill-name">{{ $sale->customer_name }}</p>
                    <div class="bill-detail">
                        {!! nl2br(e($sale->billing_address ?: '')) !!}
                        @if($sale->customer_phone)<br><strong>Phone:</strong> {{ $sale->customer_phone }}@endif
                        @if($sale->customer_email)<br><strong>Email:</strong> {{ $sale->customer_email }}@endif
                        <br><strong>GST:</strong> {{ $sale->customer_gst ?: '-' }}
                        &nbsp;&nbsp;<strong>PAN:</strong> {{ $sale->customer_pan ?: '-' }}
                    </div>
                </div>

                <div class="inv-info-col">
                    <p class="info-section-label">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        Invoice details
                    </p>
                    <div class="meta-grid">
                        <div class="meta-row">
                            <span class="meta-label">Invoice No</span>
                            <span class="meta-value mono">{{ $sale->invoice_no }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Date</span>
                            <span
                                class="meta-value">{{ \Carbon\Carbon::parse($sale->created_at)->format('d-m-Y') }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">PO No</span>
                            <span class="meta-value mono">{{ $sale->po_no ?: '-' }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Challan No</span>
                            <span class="meta-value mono">{{ $sale->challan_no ?: '-' }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Vehicle No</span>
                            <span class="meta-value">{{ $sale->vehicle_no ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject -->
            <div class="inv-subject-row">
                <strong>Subject:</strong>
                {{ $sale->subject ?: 'Supply & Delivery of materials as per purchase order.' }}
            </div>

            <!-- Products Table -->
            <div class="inv-table-wrap">
                <table class="inv-products">
                    <thead>
                        <tr>
                            <th style="width:40px;" class="c">Sl</th>
                            <th style="width:100px;">SKU</th>
                            <th>Product</th>
                            <th style="width:90px;" class="r">Rate</th>
                            <th style="width:55px;" class="c">Qty</th>
                            <th style="width:70px;" class="c">GST %</th>
                            <th style="width:90px;" class="r">GST Amt</th>
                            <th style="width:100px;" class="r">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $index => $item)
                            <tr>
                                <td class="c sl-num">{{ $index + 1 }}</td>
                                <td><span class="sku-pill">{{ $item->sku }}</span></td>
                                <td class="product-name">{{ $item->product_name }}</td>
                                <td class="r amount-cell">₹{{ number_format($item->unit_price, 2) }}</td>
                                <td class="c">{{ $item->quantity }}</td>
                                <td class="c"><span class="gst-badge">{{ number_format($item->gst_percentage, 2) }}%</span>
                                </td>
                                <td class="r amount-cell">₹{{ number_format($item->gst_amount, 2) }}</td>
                                <td class="r amount-cell">₹{{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Bank Details + Totals -->
            <div class="inv-bottom-row">
                <div class="inv-bank-col">
                    <p class="info-section-label" style="margin-bottom:12px;">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="5" width="20" height="14" rx="2" />
                            <line x1="2" y1="10" x2="22" y2="10" />
                        </svg>
                        Bank details
                    </p>
                    <div class="bank-row"><span>Bank</span><strong>{{ $setting->bank_name ?? '-' }}</strong></div>
                    <div class="bank-row"><span>A/C No</span><strong>{{ $setting->bank_account_no ?? '-' }}</strong>
                    </div>
                    <div class="bank-row"><span>IFSC</span><strong>{{ $setting->bank_ifsc ?? '-' }}</strong></div>
                </div>

                <div class="inv-totals-col">
                    <div class="total-line">
                        <span class="total-label">Taxable value</span>
                        <span class="total-value">₹{{ number_format($sale->subtotal, 2) }}</span>
                    </div>
                    <div class="total-line">
                        <span class="total-label">Total GST</span>
                        <span class="total-value">₹{{ number_format($sale->gst_amount, 2) }}</span>
                    </div>
                    <div class="total-line total-grand">
                        <span class="total-label">Grand total</span>
                        <span class="total-value">₹{{ number_format($sale->grand_total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Amount in Words + Signature -->
            <div class="inv-footer-row">
                <div class="inv-words-col">
                    <p class="words-label">Amount in words</p>
                    <p class="words-value">
                        {{ ucwords(numberToWords((int) round($sale->grand_total))) }} Rupees Only
                    </p>
                </div>

                <div class="inv-sig-col">
                    <div class="sig-for">
                        For <strong>{{ $setting->brand_name ?? 'Company' }}</strong>
                    </div>
                    <div class="sig-line">Authorised Signatory</div>
                </div>
            </div>

        </div><!-- /invoice-card -->
    </div><!-- /page-wrap -->

</body>

</html>