@extends('layouts.app')

@section('title', 'Edit Purchase Invoice')

@section('styles')
<style>
    .file-input { cursor: pointer; }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-edit"></i> Edit Purchase Invoice</h1>
        <a href="{{ route('purchases.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Purchase List</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('purchases.update', $purchase) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Purchase Invoice No</label>
                <input type="text" name="purchase_invoice_no" class="form-control" value="{{ old('purchase_invoice_no', $purchase->purchase_invoice_no) }}" required>
            </div>
            <div class="form-group">
                <label>Purchase Date</label>
                <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', optional($purchase->purchase_date)->format('Y-m-d')) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Replace Purchase Invoice PDF <span style="font-weight:400;color:var(--text-muted);">(optional)</span></label>
            <input type="file" name="purchase_invoice_pdf" class="form-control file-input" accept="application/pdf">
        </div>

        <button type="submit" class="btn" style="margin-top:8px;"><i class="fas fa-save"></i> Save Changes</button>
    </form>
</div>
@endsection
