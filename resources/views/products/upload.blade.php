@extends('layouts.app')

@section('title', 'Upload Products')

@section('styles')
<style>
    .upload-zone { border: 2px dashed var(--border); border-radius: 12px; padding: 48px 24px; text-align: center; transition: all .15s ease; cursor: pointer; }
    .upload-zone:hover { border-color: var(--accent); background: #f8faff; }
    .upload-zone i { font-size: 48px; color: var(--text-muted); margin-bottom: 16px; }
    .upload-zone p { color: var(--text-muted); font-size: 14px; }
    .upload-zone p strong { color: var(--text); }
    .upload-zone input[type="file"] { margin-top: 16px; }
    .section-title { font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
    .section-title i { color: var(--accent); }
    .hint { font-size: 13px; color: var(--text-muted); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-upload"></i> Upload Products</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <p class="hint"><i class="fas fa-info-circle"></i> Accepted formats: XLSX, XLS, CSV</p>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('products.upload.post') }}" enctype="multipart/form-data">
        @csrf
        <div class="upload-zone">
            <i class="fas fa-cloud-upload-alt"></i>
            <p><strong>Click to choose file</strong> or drag and drop</p>
            <input type="file" name="file" required>
        </div>
        <div style="margin-top:20px; display:flex; gap:12px; flex-wrap:wrap;">
            <button type="submit" class="btn btn-success"><i class="fas fa-sync"></i> Upload &amp; Sync</button>
        </div>
    </form>
</div>

<div class="card">
    <div class="section-title"><i class="fas fa-table"></i> Expected Excel Columns</div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>SL. NO.</th>
                    <th>MATERIAL CODE</th>
                    <th>DESCRIPTION OF MATERIAL</th>
                    <th>HSN CODE</th>
                    <th>MAIN CATEGORY</th>
                    <th>SUB CATEGORY</th>
                    <th>UNIT</th>
                    <th>GST %</th>
                    <th>COST (INCL. GST)</th>
                    <th>SELLING PRICE</th>
                    <th>QTY</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>110030141</td>
                    <td>EcoPro Wireless Mouse</td>
                    <td>HSN1</td>
                    <td>Electronics</td>
                    <td>Mouse</td>
                    <td>NOS</td>
                    <td>18</td>
                    <td>1499</td>
                    <td>1999</td>
                    <td>45</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection