@extends('layouts.app')

@section('title', 'Company Settings')

@section('styles')
<style>
    .logo-preview { max-height: 80px; display: block; margin-bottom: 15px; border-radius: 8px; border: 1px solid var(--border); padding: 4px; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; font-family: inherit; transition: border .15s ease; background: #fff; color: var(--text); box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
    textarea.form-control { resize: vertical; min-height: 80px; }
    .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
</style>
@endsection

@section('content')
<div class="card" style="max-width: 900px;">
    <div class="card-header">
        <h1><i class="fas fa-cog"></i> Company Settings</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Company Name *</label>
                <input type="text" name="brand_name" class="form-control" value="{{ old('brand_name', $setting->brand_name) }}" required>
            </div>
            <div class="form-group">
                <label>Proprietor Name</label>
                <input type="text" name="proprietor_name" class="form-control" value="{{ old('proprietor_name', $setting->proprietor_name) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Company Description</label>
            <textarea name="company_description" class="form-control">{{ old('company_description', $setting->company_description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Logo</label>
            @if($setting->logo)
                <img class="logo-preview" src="{{ asset('storage/' . $setting->logo) }}" alt="Logo">
            @endif
            <input type="file" name="logo" class="form-control">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>GST Number</label>
                <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number', $setting->gst_number) }}">
            </div>
            <div class="form-group">
                <label>PAN Number</label>
                <input type="text" name="pan_number" class="form-control" value="{{ old('pan_number', $setting->pan_number) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ old('address', $setting->address) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email) }}">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $setting->phone) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Udyam Number</label>
                <input type="text" name="udyam_no" class="form-control" value="{{ old('udyam_no', $setting->udyam_no) }}">
            </div>
            <div class="form-group">
                <label>Vendor Code</label>
                <input type="text" name="vendor_code" class="form-control" value="{{ old('vendor_code', $setting->vendor_code) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Bank Name</label>
                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $setting->bank_name) }}">
            </div>
            <div class="form-group">
                <label>Bank Account Number</label>
                <input type="text" name="bank_account_no" class="form-control" value="{{ old('bank_account_no', $setting->bank_account_no) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Bank IFSC / Branch</label>
                <input type="text" name="bank_ifsc" class="form-control" value="{{ old('bank_ifsc', $setting->bank_ifsc) }}">
            </div>
            <div class="form-group">
                <label>Default GST Percentage</label>
                <input type="number" step="0.01" min="0" max="100" name="default_gst_percent" class="form-control" value="{{ old('default_gst_percent', $setting->default_gst_percent) }}" required>
            </div>
        </div>

        <button type="submit" class="btn"><i class="fas fa-save"></i> Save Settings</button>
    </form>
</div>
@endsection
