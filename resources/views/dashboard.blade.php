@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">RINGKASAN TOKO</div>
<h1>Selamat datang, {{ explode(' ',auth()->user()->name)[0] }} <span style="font-size:23px">☀</span>
</h1>
<p class="subtle mb-0">Ini yang terjadi di toko Anda hari ini.</p>
</div>
<a class="btn btn-primary" href="{{ route('pos.index') }}">
<i class="fa-solid fa-plus me-2">
</i> Transaksi baru</a>
</div>
<div class="row g-3 mb-4">@foreach([['Pendapatan hari ini',$revenue,'fa-wallet',true],['Laba hari ini',$profit,'fa-arrow-trend-up',true],['Transaksi hari ini',$count,'fa-receipt',false],['Barang aktif',$itemCount,'fa-box-open',false]] as [$label,$value,$icon,$money])<div class="col-sm-6 col-xl-3">
<div class="card h-100">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center">
<span class="stat-label">{{ $label }}</span>
<span class="stat-icon">
<i class="fa-solid {{ $icon }}">
</i>
</span>
</div>
<div class="stat-number">@if($money) @currency($value) @else {{ $value }} @endif</div>
<span class="small subtle">{{ $money?'Tercatat dari transaksi berhasil':($label==='Barang aktif'?'Tersedia dalam inventori':'Penjualan yang diselesaikan') }}</span>
</div>
</div>
</div>@endforeach</div>
<div class="row g-4 mb-4">
<div class="col-lg-8">
<div class="card h-100">
<div class="card-body">
<div class="d-flex justify-content-between">
<div>
<h2>Tren penjualan</h2>
<p class="small subtle mb-0">Pendapatan selama 7 hari terakhir</p>
</div>
<span class="badge badge-soft align-self-start">7 hari terakhir</span>
</div>
<div class="bar-chart">@foreach($week as $day)<div class="chart-col">
<span title="Rp {{ number_format($day['total'],0,',','.') }}">{{ $day['total']?number_format($day['total']/1000,0).'k':'0' }}</span>
<div class="chart-bar" style="height:{{ max(2,$day['total']/max(1,$week->max('total'))*140) }}px">
</div>
<span>{{ $day['day'] }}</span>
</div>@endforeach</div>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="card h-100">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-3">
<h2 class="mb-0">Perlu restok</h2>
<span class="badge badge-low">Stok ≤ 5</span>
</div>@forelse($lowStock as $item)<div class="d-flex align-items-center justify-content-between py-2 border-bottom">
<div>
<div class="small fw-semibold">{{ $item->name }}</div>
<small class="subtle">{{ $item->item_code }}</small>
</div>
<span class="badge badge-low">{{ $item->stock }} {{ $item->unit }}</span>
</div>@empty<div class="empty-state">
<i class="fa-solid fa-circle-check fs-3 mb-3">
</i>
<p>Stok barang dalam kondisi baik.</p>
</div>@endforelse<a class="small d-block mt-3" href="{{ route('items.index') }}">Lihat inventori <i class="fa-solid fa-arrow-right ms-2">
</i>
</a>
</div>
</div>
</div>
</div>
<div class="card">
<div class="card-body">
<div class="d-flex justify-content-between mb-3">
<h2>Transaksi terbaru</h2>
<a class="small" href="{{ route('reports.index') }}">Lihat semua <i class="fa-solid fa-arrow-right ms-2">
</i>
</a>
</div>@include('partials.transactions',['transactions'=>$recent])</div>
</div>
@endsection
