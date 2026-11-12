@extends('layouts.app')
@section('title','Laporan penjualan')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">PERFORMA TOKO</div>
<h1>Laporan penjualan</h1>
<p class="subtle mb-0">Pantau pendapatan dan laba dari setiap penjualan.</p>
</div>
<div class="d-flex gap-2">
<a class="btn btn-light border" href="{{ route('reports.pdf',['start_date'=>$start,'end_date'=>$end]) }}">
<i class="fa-regular fa-file-pdf me-2">
</i> PDF</a>
<a class="btn btn-primary" href="{{ route('reports.excel',['start_date'=>$start,'end_date'=>$end]) }}">
<i class="fa-regular fa-file-excel me-2">
</i> Ekspor Excel</a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<form class="row g-3 align-items-end" method="GET">
<div class="col-md-4">
<label for="start_date" class="form-label">Dari tanggal</label>
<input type="date" id="start_date" name="start_date" class="form-control" value="{{ $start }}" required>
</div>
<div class="col-md-4">
<label for="end_date" class="form-label">Sampai tanggal</label>
<input type="date" id="end_date" name="end_date" class="form-control" value="{{ $end }}" required>
</div>
<div class="col-md-4">
<button class="btn btn-outline-primary">
<i class="fa-solid fa-filter me-2">
</i> Tampilkan laporan</button>
</div>
</form>
</div>
</div>
<div class="row g-3 mb-4">@foreach([['Total pendapatan',$revenue,true],['Total laba',$profit,true],['Jumlah transaksi',$count,false]] as [$label,$value,$money])<div class="col-md-4">
<div class="card">
<div class="card-body">
<div class="stat-label">{{ $label }}</div>
<div class="stat-number mb-0">@if($money) @currency($value) @else {{ $value }} @endif</div>
</div>
</div>
</div>@endforeach</div>
<div class="card">
<div class="card-body">
<h2 class="mb-4">Detail transaksi</h2>@include('partials.transactions',['dataTable'=>true])</div>
</div>
@endsection
