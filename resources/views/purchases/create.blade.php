@extends('layouts.app')

@section('title', 'Add Purchase')

@section('styles')
<style>
    .file-input { cursor: pointer; }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-cart-plus"></i> Add Purchase</h1>
        <a href="{{ route('purchases.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Purchase List</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('purchases.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Purchase Invoice No</label>
                <input type="text" name="purchase_invoice_no" id="purchaseInvoiceNo" class="form-control" value="{{ old('purchase_invoice_no') }}" required>
            </div>
            <div class="form-group">
                <label>Purchase Date</label>
                <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Purchase Invoice PDF</label>
            <input type="file" name="purchase_invoice_pdf" class="form-control file-input" accept="application/pdf" required>
        </div>

        <button type="submit" class="btn" style="margin-top:8px;"><i class="fas fa-upload"></i> Upload Invoice</button>
    </form>
</div>
@endsection
