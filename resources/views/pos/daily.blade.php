@extends('layouts.app')
@section('title','Penjualan hari ini')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">AKTIVITAS KASIR</div>
<h1>Penjualan hari ini</h1>
<p class="subtle mb-0">{{ now()->format('d M Y') }} · {{ auth()->user()->role==='admin'?'Semua kasir':'Transaksi Anda' }}</p>
</div>
<a class="btn btn-primary" href="{{ route('pos.index') }}">Transaksi baru</a>
</div>
<div class="card mb-4">
<div class="card-body">
<div class="stat-label">Total penjualan hari ini</div>
<div class="stat-number mb-0">@currency($total)</div>
</div>
</div>
<div class="card">
<div class="card-body">@include('partials.transactions')<div class="mt-3">{{ $transactions->links() }}</div>
</div>
</div>
@endsection
