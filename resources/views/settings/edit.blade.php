@extends('layouts.app')

@section('title', 'Company Settings')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            padding: 40px;
        }

        .card {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        .row {
            display: flex;
            gap: 20px;
        }

        .col {
            flex: 1;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
        }

        .btn {
            padding: 10px 18px;
            background: #0f172a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        img.logo-preview {
            max-height: 80px;
            display: block;
            margin-bottom: 15px;
        }

        h1 {
            margin-top: 0;
        }
    </style>
@endsection


@section('content')
    <div class="card">
        <h1>Company Settings</h1>

        <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>

        <br><br>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf

            <label>Company Name *</label>
            <input type="text" name="brand_name" value="{{ old('brand_name', $setting->brand_name) }}" required>

            <label>Proprietor Name</label>
            <input type="text" name="proprietor_name" value="{{ old('proprietor_name', $setting->proprietor_name) }}">

            <label>Company Description</label>
            <textarea name="company_description">{{ old('company_description', $setting->company_description) }}</textarea>

            <label>Logo</label>

            @if($setting->logo)
                <img class="logo-preview" src="{{ asset('storage/' . $setting->logo) }}" alt="Logo">
            @endif

            <input type="file" name="logo">

            <div class="row">
                <div class="col">
                    <label>GST Number</label>
                    <input type="text" name="gst_number" value="{{ old('gst_number', $setting->gst_number) }}">
                </div>

                <div class="col">
                    <label>PAN Number</label>
                    <input type="text" name="pan_number" value="{{ old('pan_number', $setting->pan_number) }}">
                </div>
            </div>

            <label>Address</label>
            <textarea name="address">{{ old('address', $setting->address) }}</textarea>

            <div class="row">
                <div class="col">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $setting->email) }}">
                </div>

                <div class="col">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $setting->phone) }}">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Udyam Number</label>
                    <input type="text" name="udyam_no" value="{{ old('udyam_no', $setting->udyam_no) }}">
                </div>

                <div class="col">
                    <label>Vendor Code</label>
                    <input type="text" name="vendor_code" value="{{ old('vendor_code', $setting->vendor_code) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Bank Name</label>
                <input type="text" name="bank_name" class="form-control"
                    value="{{ old('bank_name', $setting->bank_name) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Bank Account Number</label>
                <input type="text" name="bank_account_no" class="form-control"
                    value="{{ old('bank_account_no', $setting->bank_account_no) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Bank IFSC / Branch</label>
                <input type="text" name="bank_ifsc" class="form-control"
                    value="{{ old('bank_ifsc', $setting->bank_ifsc) }}">
            </div>

            <label>Default GST Percentage</label>
            <input type="number" step="0.01" min="0" max="100" name="default_gst_percent"
                value="{{ old('default_gst_percent', $setting->default_gst_percent) }}" required>

            <button type="submit" class="btn">Save Settings</button>
        </form>
    </div>
@endsection