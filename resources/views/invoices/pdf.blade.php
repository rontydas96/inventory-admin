<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sale Complete - {{ $sale->invoice_no }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&family=Great+Vibes&family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">
  <style>
    @page {
      size: A4 portrait;
      margin: 0;
    }

    :root {
      /* ── Colors ── */
      --white: #ffffff;
      --body-bg: #dce6e8;
      --primary-teal: #0a7e7c;
      --primary-dark-teal: #065f5d;
      --primary-light-teal: #d0f0ef;
      --accent-orange: #f39223;
      --red: #c0392b;
      --text-dark: #1a1a1a;
      --text-body: #2a2a2a;
      --text-subject: #222;
      --text-muted: #555;
      --text-light: #666;
      --text-white: #ffffff;
      --header-sub-text: #e8fafa;
      --contact-label: #ffe082;
      --border-dark: #2d2d2d;
      --border-light: #c8d8d8;
      --border-faint: #b0c4c4;
      --table-border: #bccfcf;
      --table-header-border: #076260;
      --cost-border: #d0e4e4;
      --bank-border: #d0dcdc;
      --sig-border: #d0e0e0;
      --header-container-bg: #f4fbfb;
      --address-bg: #fdf3d0;
      --title-bg: #f2f9f9;
      --section-title-bg: #e6f7f7;
      --total-row-bg: #eef8f8;
      --ref-bg: #fafcfc;
      --bank-bg: #fafefe;
      --words-bg: #fdf5d0;
      --table-stripe: #f7fdfd;
      --spacer-bg: #fafcfc;
      --header-sub-bg: #0e8a88;

      /* ── Font Families ── */
      --font-body: 'Inter', sans-serif;
      --font-heading: 'Montserrat', sans-serif;
      --font-company: 'Cinzel', serif;
      --font-signature: 'Great Vibes', cursive;

      /* ── Font Sizes ── */
      --text-2xs: 8px;
      --text-xs: 8.5px;
      --text-sm: 9px;
      --text-base: 9.5px;
      --text-md: 10px;
      --text-lg: 10.5px;
      --text-xl: 11px;
      --text-2xl: 11.5px;
      --text-3xl: 12px;
      --text-4xl: 14px;
      --text-5xl: 18px;
      --text-6xl: 20px;

      /* ── Font Weights ── */
      --fw-medium: 500;
      --fw-semibold: 600;
      --fw-bold: 700;
      --fw-extrabold: 800;

      /* ── Border Radius ── */
      --radius-sm: 2px;
      --radius-md: 3px;
      --radius-lg: 6px;
      --radius-full: 50%;

      /* ── Spacing (padding, margin, gap) ── */
      --space-1: 1px;
      --space-2: 2px;
      --space-3: 3px;
      --space-4: 4px;
      --space-5: 5px;
      --space-6: 6px;
      --space-8: 8px;
      --space-10: 10px;
      --space-12: 12px;
      --space-14: 14px;
      --space-16: 16px;
      --space-20: 20px;
      --space-24: 24px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      color: var(--text-dark);
      background: var(--body-bg);
      padding: var(--space-20);
      display: flex;
      flex-direction: column;
      align-items: center;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    body,
    .print-btn {
      /* font-family: var(--font-body); */
      font-family: 'DejaVu Sans', sans-serif;
    }

    .company-sub1,
    .company-sub2,
    .gst-pan-box,
    .proprietor-box,
    .address-band,
    .title-band,
    .footer-left-contact,
    .footer-right-sig {
      font-family: var(--font-heading);
    }

    .inv-logo {
        max-width: 120px;
        max-height: 80px;
    }

    /* ── Print Button ── */
    .print-btn {
      display: inline-flex;
      align-items: center;
      gap: var(--space-8);
      padding: var(--space-10) var(--space-24);
      margin-bottom: var(--space-16);
      background: var(--primary-teal);
      color: var(--white);
      border: none;
      border-radius: var(--radius-lg);
      font-size: var(--text-4xl);
      font-weight: var(--fw-semibold);
      cursor: pointer;
      box-shadow: 0 3px 12px rgba(10, 126, 124, 0.35);
    }

    .print-btn:hover {
      background: var(--primary-dark-teal);
    }

    .print-btn svg {
      width: 18px;
      height: 18px;
      fill: currentColor;
    }

    /* ── Invoice Wrapper ── */
    .invoice-wrapper {
      width: 210mm;
      min-height: 297mm;
      background: var(--white);
      border: 1px solid var(--border-light);
      border-top: 3px solid var(--primary-teal);
      box-shadow: 0 4px 24px rgba(10, 126, 124, 0.10);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ── Header ── */
    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: stretch;
      border-bottom: 1px solid var(--border-dark);
      position: relative;
      overflow: hidden;
      min-height: 108px;
      background: var(--header-container-bg);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .header-left {
      display: flex;
      align-items: center;
      padding: var(--space-10) 0 var(--space-10) var(--space-14);
      z-index: 2;
      width: 62%;
      background: var(--white);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .header-right {
      position: relative;
      width: 38%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: flex-end;
      padding: var(--space-6) var(--space-14) var(--space-6) 0;
      z-index: 2;
    }

    .logo-box {
      margin-right: var(--space-12);
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--primary-light-teal);
      border-radius: var(--radius-full);
      width: 68px;
      height: 68px;
      flex-shrink: 0;
      border: 1.5px solid var(--primary-teal);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .logo-svg {
      width: 46px;
      height: 46px;
    }

    .company-details {
      display: flex;
      flex-direction: column;
      gap: var(--space-1);
    }

    .company-name {
      font-family: var(--font-company);
      font-size: var(--text-6xl);
      font-weight: var(--fw-extrabold);
      color: var(--primary-teal);
      line-height: 1.1;
      letter-spacing: 0.3px;
    }

    .company-sub1 {
      font-size: var(--text-md);
      font-weight: var(--fw-semibold);
      color: var(--text-muted);
    }

    .company-sub2 {
      font-size: var(--text-xs);
      font-weight: var(--fw-bold);
      color: var(--text-light);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .slant-teal {
      position: absolute;
      top: 0;
      right: 0;
      height: 66px;
      width: 280px;
      background: var(--primary-teal);
      clip-path: polygon(13% 0%, 100% 0%, 100% 100%, 0% 100%);
      z-index: 1;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .slant-orange {
      position: absolute;
      top: 0;
      right: 190px;
      height: 66px;
      width: 106px;
      background: var(--accent-orange);
      clip-path: polygon(35% 0%, 100% 0%, 55% 100%, 0% 100%);
      z-index: 1;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .gst-pan-box {
      position: relative;
      z-index: 3;
      color: var(--text-white);
      font-size: var(--text-md);
      font-weight: var(--fw-bold);
      text-align: right;
      line-height: 1.5;
      padding-top: var(--space-10);
      letter-spacing: 0.2px;
    }

    .proprietor-box {
      font-size: var(--text-3xl);
      color: var(--text-dark);
      font-weight: bold;
      margin-top: auto;
      text-align: right;
      z-index: 3;
      padding-bottom: var(--space-4);
    }

    .proprietor-box span {
      color: var(--primary-teal);
      font-weight: 500;
    }

    /* ── Address & Title Bands ── */
    .address-band {
      background: var(--address-bg);
      border-bottom: 1px solid var(--border-dark);
      text-align: center;
      padding: var(--space-5) var(--space-10);
      font-size: var(--text-xl);
      font-weight: var(--fw-bold);
      color: var(--red);
      letter-spacing: 0.2px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--space-6);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .address-band::before,
    .address-band::after {
      content: '\2726';
      font-size: var(--text-2xs);
      color: var(--accent-orange);
      opacity: 0.7;
    }

    .title-band {
      text-align: center;
      padding: var(--space-10) 0;
      border-bottom: 1px solid var(--border-dark);
      font-weight: var(--fw-extrabold);
      font-size: var(--text-4xl);
      letter-spacing: 2px;
      background: var(--title-bg);
      color: var(--text-dark);
      text-transform: uppercase;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ── Client Details Grid ── */
    .details-grid {
      display: grid;
      grid-template-columns: 3.2fr 3.2fr 3.6fr;
      border-bottom: 1px solid var(--border-dark);
    }

    .details-col {
      padding: var(--space-8);
      font-size: var(--text-md);
      line-height: 1.5;
    }

    .details-col:not(:last-child) {
      border-right: 1px solid var(--border-dark);
    }

    .col-header {
      font-weight: var(--fw-extrabold);
      font-size: var(--text-md);
      margin-bottom: var(--space-5);
      text-align: center;
      color: var(--text-white);
      background: var(--primary-teal);
      padding: var(--space-5) var(--space-5);
      border-radius: var(--radius-sm);
      letter-spacing: 0.2px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .details-row {
      margin-bottom: var(--space-2);
      display: flex;
    }

    .details-label {
      font-weight: var(--fw-bold);
      width: 54px;
      flex-shrink: 0;
      color: var(--primary-dark-teal);
      font-size: var(--text-md);
    }

    .details-val {
      flex-grow: 1;
      color: var(--text-dark);
      font-size: var(--text-md);
    }

    .meta-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: var(--space-2);
      font-size: var(--text-md);
      padding-bottom: var(--space-2);
    }

    .meta-row:last-child {
      border-bottom: none;
    }

    .meta-label {
      font-weight: var(--fw-bold);
      width: 84px;
      color: var(--primary-dark-teal);
      font-size: var(--text-md);
    }

    .meta-val {
      font-weight: var(--fw-bold);
      flex-grow: 1;
      text-align: left;
      font-size: var(--text-md);
    }

    .po-badge {
      background: var(--primary-light-teal);
      border: 1px solid var(--primary-teal);
      border-radius: var(--radius-md);
      padding: var(--space-1) var(--space-5);
      font-weight: var(--fw-extrabold);
      color: var(--primary-dark-teal);
      font-size: var(--text-md);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ── Subject & Reference ── */
    .subject-ref-grid {
      display: grid;
      grid-template-columns: 6.4fr 3.6fr;
      border-bottom: 1px solid var(--border-dark);
    }

    .subject-block {
      padding: var(--space-6) var(--space-8);
      border-right: 1px solid var(--border-dark);
      font-size: var(--text-md);
      line-height: 1.5;
      display: flex;
      background: var(--header-container-bg);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .subject-label {
      font-weight: var(--fw-extrabold);
      margin-right: var(--space-4);
      flex-shrink: 0;
      color: var(--primary-teal);
      font-size: var(--text-lg);
    }

    .subject-text {
      font-weight: var(--fw-medium);
      color: var(--text-subject);
      font-size: var(--text-md);
    }

    .ref-block {
      padding: var(--space-6) var(--space-8);
      font-size: var(--text-md);
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: var(--ref-bg);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .ref-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: var(--space-2);
      padding-bottom: var(--space-1);
    }

    .ref-row:last-child {
      border-bottom: none;
      margin-bottom: 0;
    }

    .ref-label {
      font-weight: var(--fw-bold);
      width: 90px;
      color: var(--primary-dark-teal);
      font-size: var(--text-md);
    }

    .ref-val {
      flex-grow: 1;
      font-weight: var(--fw-semibold);
      font-size: var(--text-md);
    }

    /* ── Products Table ── */
    .products-table-container {
      width: 100%;
      border-bottom: 1px solid var(--border-dark);
    }

    .products-table {
      width: 100%;
      border-collapse: collapse;
      font-size: var(--text-md);
    }

    .products-table th,
    .products-table td {
      border: 1px solid var(--table-border);
      padding: var(--space-10) var(--space-6);
      text-align: center;
      vertical-align: middle;
    }

    .products-table td.left-align {
      text-align: left;
      padding-left: var(--space-6);
    }

    .products-table td.right-align {
      text-align: right;
      padding-right: var(--space-6);
    }

    .header-main-row th {
      font-weight: var(--fw-extrabold);
      font-size: var(--text-md);
      background: var(--primary-teal);
      color: var(--text-white);
      border-color: var(--table-header-border);
      letter-spacing: 0.2px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .header-sub-row th {
      font-weight: var(--fw-bold);
      font-size: var(--text-xs);
      background: var(--header-sub-bg);
      color: var(--header-sub-text);
      border-color: var(--table-header-border);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .table-section-title {
      background: var(--section-title-bg);
      font-weight: var(--fw-extrabold);
      font-size: var(--text-sm);
      text-transform: uppercase;
      letter-spacing: 1.2px;
      padding: var(--space-3);
      color: var(--primary-dark-teal);
      border-color: var(--border-faint);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .col-sl {
      width: 4.5%;
    }

    .col-desc {
      width: 34.5%;
    }

    .col-hsn {
      width: 8%;
    }

    .col-unit {
      width: 7%;
    }

    .col-rate {
      width: 8%;
    }

    .col-qty {
      width: 8%;
    }

    .col-amount {
      width: 10.5%;
    }

    .col-cgst-rate {
      width: 4%;
    }

    .col-cgst-amt {
      width: 8%;
    }

    .desc-text {
      font-style: italic;
      font-weight: var(--fw-semibold);
      color: var(--text-dark);
    }

    .products-table tbody tr:nth-child(odd):not(.total-row):not(.spacer-row) {
      background-color: var(--table-stripe);
    }

    .spacer-row td {
      background: var(--spacer-bg);
    }

    .total-row td {
      font-weight: var(--fw-extrabold);
      font-size: var(--text-md);
      background: var(--total-row-bg);
      color: var(--primary-dark-teal);
      border-top: 1px solid var(--border-dark);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ── Bottom Grid ── */
    .bottom-grid {
      display: grid;
      grid-template-columns: 6.4fr 3.6fr;
      border-bottom: 1px solid var(--border-dark);
    }

    .bottom-left-panel {
      border-right: 1px solid var(--border-dark);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .bank-details-box {
      padding: var(--space-8) var(--space-10);
      font-size: var(--text-md);
      line-height: 1.5;
      background: var(--bank-bg);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .bank-line {
      margin-bottom: var(--space-1);
      color: var(--text-body);
      font-size: var(--text-md);
    }

    .bank-line-bold {
      font-weight: var(--fw-bold);
      color: var(--primary-dark-teal);
    }

    .bank-disclaimer {
      font-style: italic;
      margin-top: var(--space-4);
      line-height: 1.4;
      font-weight: var(--fw-medium);
      color: var(--text-light);
      border-top: 1px dashed var(--bank-border);
      padding-top: var(--space-4);
      font-size: var(--text-sm);
    }

    .words-amount-box {
      border-top: 1px solid var(--border-dark);
      padding: 10.5px 10.5px;
      font-size: var(--text-md);
      background: var(--words-bg);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .words-label {
      font-weight: var(--fw-extrabold);
      text-decoration: underline;
      margin-bottom: var(--space-2);
      color: var(--primary-dark-teal);
      font-size: var(--text-md);
    }

    .words-val {
      font-weight: var(--fw-semibold);
      color: var(--text-body);
      font-style: italic;
      font-size: var(--text-md);
    }

    .cost-summary-panel {
      display: flex;
      flex-direction: column;
    }

    .cost-summary-title {
      border-bottom: 1px solid var(--border-dark);
      text-align: center;
      padding: var(--space-5) 0;
      font-weight: var(--fw-extrabold);
      font-size: var(--text-md);
      letter-spacing: 1.2px;
      background: var(--primary-teal);
      color: var(--text-white);
      text-transform: uppercase;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .cost-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--cost-border);
      font-size: var(--text-md);
      padding: var(--space-16) 0;
    }

    .cost-row:last-child {
      border-bottom: none;
      background: var(--primary-light-teal);
      padding: var(--space-16) 0;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .cost-row:nth-child(2) {
      background: var(--ref-bg);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .cost-row:nth-child(3) {
      background: var(--total-row-bg);
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .cost-label {
      font-weight: var(--fw-semibold);
      padding-left: var(--space-8);
      flex-grow: 1;
      color: var(--text-body);
      font-size: var(--text-md);
    }

    .cost-val {
      font-weight: var(--fw-extrabold);
      padding-right: var(--space-8);
      width: 100px;
      text-align: right;
      flex-shrink: 0;
      color: var(--primary-dark-teal);
      font-size: var(--text-md);
    }

    .cost-row:last-child .cost-label,
    .cost-row:last-child .cost-val {
      font-weight: var(--fw-extrabold);
      font-size: var(--text-2xl);
      color: var(--primary-dark-teal);
    }

    /* ── Footer ── */
    .footer-action-container {
      display: flex;
      justify-content: space-between;
      align-items: stretch;
      min-height: 58px;
      margin-top: auto;
    }

    .footer-left-contact {
      position: relative;
      width: 60%;
      background: var(--primary-dark-teal);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding-left: var(--space-16);
      color: var(--text-white);
      font-size: var(--text-lg);
      font-weight: var(--fw-semibold);
      line-height: 1.5;
      overflow: hidden;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .footer-orange-stripe {
      position: absolute;
      top: 0;
      right: -1px;
      height: 100%;
      width: 42px;
      background: var(--accent-orange);
      clip-path: polygon(100% 0, 100% 100%, 0% 50%);
      z-index: 2;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .contact-item {
      display: flex;
      align-items: center;
      gap: var(--space-3);
    }

    .contact-label {
      font-weight: var(--fw-bold);
      color: var(--contact-label);
      font-size: var(--text-md);
    }

    .footer-right-sig {
      width: 40%;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      align-items: center;
      padding-bottom: var(--space-6);
      font-size: var(--text-md);
      font-weight: var(--fw-extrabold);
      color: var(--primary-dark-teal);
      border-top: 1px solid var(--sig-border);
      gap: var(--space-4);
    }

    /* ── Print Overrides ── */
    @media print {

      html,
      body {
        width: 210mm;
        height: 297mm;
        margin: 0;
        padding: 0;
      }

      body {
        background: var(--white);
        display: block;
      }

      .print-btn {
        display: none !important;
      }

      .no-print {
        display: none !important;
      }

      .invoice-wrapper {
        width: 210mm;
        min-height: 297mm;
        border: none;
        border-top: 2px solid var(--primary-teal);
        box-shadow: none;
        margin: 0;
        padding: 0;
        page-break-after: avoid;
      }

      .header-container,
      .header-left,
      .logo-box,
      .slant-teal,
      .slant-orange,
      .address-band,
      .title-band,
      .col-header,
      .po-badge,
      .subject-block,
      .ref-block,
      .header-main-row th,
      .header-sub-row th,
      .table-section-title,
      .total-row td,
      .bank-details-box,
      .words-amount-box,
      .cost-summary-title,
      .cost-row,
      .footer-left-contact,
      .footer-orange-stripe {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }

      .header-left {
        background: var(--white) !important;
      }

      .header-container {
        background: var(--header-container-bg) !important;
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

    @php
        $logoPath = !empty(optional($setting)->logo) ? public_path('storage/' . optional($setting)->logo) : null;
    @endphp

  <div class="invoice-wrapper">
    <div class="header-container">
      <div class="slant-orange"></div>
      <div class="slant-teal"></div>
      <div class="header-left">
        <div class="logo-box">
            @php
                $logoPath = !empty(optional($setting)->logo) ? public_path('storage/' . optional($setting)->logo) : null;
                if ($logoPath) {
                    // Normalize slashes for Windows
                    $logoPath = str_replace('\\', '/', $logoPath);
                }
            @endphp

            @if(!empty(optional($setting)->logo) && $logoPath && file_exists($logoPath))
                <img src="{{ $logoPath }}" class="inv-logo" alt="Logo">
            @else
                <svg class="logo-svg" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="44" stroke="var(--primary-teal)" stroke-width="3.5" fill="none" />
                    <circle cx="50" cy="50" r="33" stroke="var(--primary-teal)" stroke-width="2" fill="none" />
                    <circle cx="50" cy="50" r="19" stroke="var(--primary-teal)" stroke-width="1.5" fill="none" />
                    <path d="M 50 6 L 50 94" stroke="var(--primary-teal)" stroke-width="2.5" />
                    <path d="M 6 50 L 94 50" stroke="var(--primary-teal)" stroke-width="2.5" />
                    <path d="M 18 18 L 82 82" stroke="var(--primary-teal)" stroke-width="1.8" />
                    <path d="M 18 82 L 82 18" stroke="var(--primary-teal)" stroke-width="1.8" />
                    <circle cx="50" cy="50" r="5" fill="var(--accent-orange)" />
                </svg>
            @endif
        </div>
        <div class="company-details">
          <h1 class="company-name">{{ $setting->brand_name ?? 'Your Company Name' }}</h1>
          <span class="company-sub1">{{ $setting->company_description ?? '' }}</span>
          <span class="company-sub2">Govt. contractor &amp; General order supplier</span>
        </div>
      </div>
      <div class="header-right">
        <div class="gst-pan-box">
          GSTIN No &nbsp;: &nbsp;{{ $setting->gst_number ?? '-' }}<br>
          PAN No &nbsp; - &nbsp; {{ $setting->pan_number ?? '-' }}
        </div>
        <div class="proprietor-box">Prop: <span>{{ $setting->proprietor_name ?? '' }}</span></div>
      </div>
    </div>

    <div class="address-band">{{ $setting->address ?? '' }}</div>
    <div class="title-band"><span>GST TAX INVOICE</span></div>

    <div class="details-grid">
      <div class="details-col">
        <div class="col-header">Details of the Receiver (Bill to)</div>
        <div class="details-row">
          <span class="details-label">Name:</span>
          <span class="details-val" style="font-weight:var(--fw-bold);">{{ $sale->customer_name }}</span>
        </div>
        <div class="details-row">
          <span class="details-label">Address:</span>
          <span class="details-val"><strong style="font-size:var(--text-md);">{!! nl2br(e($sale->billing_address ?: '')) !!}</strong>
          <br>
            Email - @if($sale->customer_email) {{ $sale->customer_email }}@endif &nbsp; Tel @if($sale->customer_phone){{ $sale->customer_phone }}@endif
          </span>
        </div>
        <div class="details-row" style="margin-top:var(--space-4);">
          <span class="details-label">GST/UID:</span>
          <span class="details-val" style="font-weight:var(--fw-bold);">@if($sale->customer_gst) {{ $sale->customer_gst }}@endif</span>
        </div>
        <div class="details-row">
          <span class="details-label">PAN :</span>
          <span class="details-val" style="font-weight:var(--fw-bold);">@if($sale->customer_pan) {{ $sale->customer_pan }}@endif</span>
        </div>
      </div>
      <div class="details-col">
        <div class="col-header">Details of the Consignee (Shipped to)</div>
        <div class="details-row">
          <span class="details-label">Name:</span>
          <span class="details-val" style="font-weight:var(--fw-bold);">{{ $sale->customer_name }}</span>
        </div>
        <div class="details-row">
          <span class="details-label">Address:</span>
          <span class="details-val"><strong style="font-size:10.5px;">{!! nl2br(e($sale->billing_address ?: '')) !!}</strong>
            <br>
            Email - @if($sale->customer_email) {{ $sale->customer_email }}@endif &nbsp; Tel @if($sale->customer_phone){{ $sale->customer_phone }}@endif
          </span>
        </div>
        <div class="details-row" style="margin-top:var(--space-10);">
          <span class="details-label">GST/UID:</span>
          <span class="details-val" style="font-weight:var(--fw-bold);">@if($sale->customer_gst) {{ $sale->customer_gst }}@endif</span>
        </div>
        <div class="details-row">
          <span class="details-label">PAN :</span>
          <span class="details-val" style="font-weight:var(--fw-bold);">@if($sale->customer_pan) {{ $sale->customer_pan }}@endif</span>
        </div>
      </div>
      <div class="details-col"
        style="padding-left:var(--space-10); background: var(--header-container-bg); -webkit-print-color-adjust: exact; print-color-adjust: exact;">
        <div class="meta-row"><span class="meta-label">Invoice No. :</span><span class="meta-val">{{ $sale->invoice_no }}</span></div>
        <div class="meta-row"><span class="meta-label">Invoice Dated :</span><span class="meta-val">{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y') }}</span>
        </div>
        <div class="meta-row"><span class="meta-label">PO No :</span><span class="meta-val"><span
              class="po-badge">{{ $sale->po_no ?: '-' }}</span></span></div>
        <div class="meta-row"><span class="meta-label">PO Date :</span><span class="meta-val">{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y') }}</span></div>
        <div class="meta-row"><span class="meta-label">Challan No :</span><span class="meta-val">{{ $sale->challan_no ?: '-' }}</span>
        </div>
        <div class="meta-row"><span class="meta-label">Challan Date :</span><span class="meta-val">{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y') }}</span>
        </div>
        <div class="meta-row"><span class="meta-label">Vehicle No :</span><span class="meta-val">{{ $sale->vehicle_no ?: '-' }}</span>
        </div>
        <div class="meta-row"><span class="meta-label">E-way Bill No :</span><span class="meta-val">{{ $sale->ewaybill_no ?: '-' }}</span>
        </div>
      </div>
    </div>

    <div class="subject-ref-grid">
      <div class="subject-block">
        <span class="subject-label">Sub:</span>
        <span class="subject-text">{{ $sale->subject ?: 'Supply & Delivery of materials as per purchase order.' }}</span>
      </div>
      <!-- <div class="ref-block">
        <div class="ref-row"><span class="ref-label">Ref: Memo No:</span><span class="ref-val">800/TMD/1221</span></div>
        <div class="ref-row"><span class="ref-label">Ref: Memo Date:</span><span class="ref-val">17.12.2025</span></div>
        <div class="ref-row"><span class="ref-label">E-way Bill No:</span><span class="ref-val">&nbsp;</span></div>
        <div class="ref-row"><span class="ref-label">E-way Bill Date:</span><span class="ref-val">&nbsp;</span></div>
      </div> -->
    </div>

    <div class="products-table-container">
      <table class="products-table">
        <thead>
          <tr class="header-main-row">
            <th class="col-sl" rowspan="2">Sl.<br>No</th>
            <th class="col-desc" rowspan="2">Description of Goods</th>
            <th class="col-hsn" rowspan="2">Material No</th>
            <th class="col-hsn" rowspan="2">HSN Code</th>
            <th class="col-unit" rowspan="2">Unit</th>
            <th class="col-rate" rowspan="2">Rate</th>
            <th class="col-qty" rowspan="2">Quantity</th>
            <th class="col-amount" rowspan="2">Total Amount</th>
            <th colspan="4">GST</th>
          </tr>
          <tr class="header-sub-row">
            <th class="col-cgst-rate">CGST Rate</th>
            <th class="col-cgst-amt">CGST Amount</th>
            <th class="col-sgst-rate">SGST Rate</th>
            <th class="col-sgst-amt">SGST Amount</th>
          </tr>
          <tr>
            <td colspan="12" class="table-section-title">&#9665; Products Supplied &#9665;</td>
          </tr>
        </thead>
        <tbody>

            @php
                $subtotal = 0;
            @endphp

            @foreach($sale->items as $index => $item)

                @php
                    $rowTotal = $item->unit_price * $item->quantity;
                    $subtotal += $rowTotal;
                    $halfGstRate = $item->gst_percentage / 2;
                    $halfGstAmount = $item->gst_amount / 2;
                @endphp

                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td class="left-align desc-text">
                        {{ $item->product_name }}
                    </td>

                    <td>{{ $item->material_code }}</td>

                    <td>
                        {{ optional($item->product)->hsn_code ?? '-' }}
                    </td>

                    <td>
                        {{ optional($item->product)->unit ?? '-' }}
                    </td>

                    <td>
                        ₹{{ number_format($item->unit_price, 2) }}
                    </td>

                    <td>
                        {{ $item->quantity }}
                    </td>

                    <!-- Rate × Quantity -->
                    <td class="right-align" style="font-weight:700; color:var(--primary-dark-teal);">
                        ₹{{ number_format($rowTotal, 2) }}
                    </td>

                    <td>
                        {{ number_format($halfGstRate, 2) }}%
                    </td>

                    <td class="right-align">
                        ₹{{ number_format($halfGstAmount, 2) }}
                    </td>

                    <td>
                        {{ number_format($halfGstRate, 2) }}%
                    </td>

                    <td class="right-align">
                        ₹{{ number_format($halfGstAmount, 2) }}
                    </td>
                </tr>

            @endforeach

            <tr class="spacer-row" style="height:12px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr class="total-row">

                <td colspan="7"
                    class="right-align"
                    style="padding-right:var(--space-8); letter-spacing:0.5px;">

                    TOTAL AMOUNT (Rs.)

                </td>

                <!-- Sum of all row totals -->
                <td class="right-align">
                    ₹{{ number_format($subtotal, 2) }}
                </td>

                <td></td>
                <td class="right-align">
                    ₹{{ number_format($sale->gst_amount / 2, 2) }}
                </td>
                <td></td>
                <td class="right-align">
                    ₹{{ number_format($sale->gst_amount / 2, 2) }}
                </td>

            </tr>

        </tbody>
      </table>
    </div>

    <div class="bottom-grid">
      <div class="bottom-left-panel">
        <div class="bank-details-box">
          <div class="bank-line">Payment of the Invoice may be made online through NEFT / RTGS made into our Bank
            Account in A/C Holder</div>
          <div class="bank-line"><span class="bank-line-bold">{{ $setting->brand_name ?? 'Company' }},</span></div>
          <div class="bank-line">Bank Name: <span class="bank-line-bold">{{ $setting->bank_name ?? '-' }}</span>, A/C No: <span
              class="bank-line-bold">{{ $setting->bank_account_no ?? '-' }}</span></div>
          <div class="bank-line">IFSC Code: <span
              class="bank-line-bold">{{ $setting->bank_ifsc ?? '-' }}</span></div>
          <div class="bank-disclaimer">Kindly communicate to us with the invoice details against your payments to
            facilitate accounting For IT-TDS/GST-TDS deduction if any. Certificate has to be given along with the
            payment.</div>
        </div>
        <div class="words-amount-box">
          <div class="words-label">Tax Amount Rupees (in words)</div>
          <div class="words-val">{{ ucwords(numberToWords((int) round($sale->grand_total))) }} Rupees Only</div>
        </div>
      </div>
      <div class="cost-summary-panel">
        @php
          $invoiceGstRate = $sale->subtotal > 0 ? ($sale->gst_amount / $sale->subtotal) * 100 : 0;
          $halfInvoiceGstRate = $invoiceGstRate / 2;
          $halfInvoiceGstAmount = $sale->gst_amount / 2;
        @endphp
        <div class="cost-summary-title">COST SUMMARY</div>
        <div class="cost-row"><span class="cost-label">TOTAL AMOUNT (Rs.)</span><span class="cost-val">&#8377; ₹{{ number_format($sale->subtotal, 2) }}</span>
        </div>
        <div class="cost-row"><span class="cost-label">CGST @ {{ number_format($halfInvoiceGstRate, 2) }}%</span><span class="cost-val">&#8377; ₹{{ number_format($halfInvoiceGstAmount, 2) }}</span></div>
        <div class="cost-row"><span class="cost-label">SGST @ {{ number_format($halfInvoiceGstRate, 2) }}%</span><span class="cost-val">&#8377; ₹{{ number_format($halfInvoiceGstAmount, 2) }}</span></div>
        <div class="cost-row"><span class="cost-label">TOTAL AMOUNT (Rs.)<br><small
              style="font-weight:var(--fw-semibold); font-size:var(--text-xs);">Including Tax</small></span><span
            class="cost-val" style="font-size:var(--text-2xl);">&#8377; ₹{{ number_format($sale->grand_total, 2) }}</span></div>
        <div class="cost-row"><span class="cost-label">Say Amount (Rs.)</span><span class="cost-val"
            style="font-size:var(--text-3xl); font-weight:var(--fw-extrabold);">&#8377; ₹{{ number_format($sale->grand_total, 2) }}</span></div>
      </div>
    </div>

    <div class="footer-action-container">
      <div class="footer-left-contact">
        <div class="footer-orange-stripe"></div>
        <div class="contact-item"><span class="contact-label">E-Mail
            :</span><span>@if($setting->email) {{ $setting->email }} @endif</span></div>
        <div class="contact-item" style="margin-top:var(--space-1);"><span class="contact-label">Contact
            :</span><span>@if($setting->phone) Phone: {{ $setting->phone }} @endif</span></div>
      </div>
      <div class="footer-right-sig">
        <span>Authorised Signatory</span>
      </div>
    </div>
  </div>

</body>

</html>