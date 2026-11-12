@extends('layouts.app')
@section('title','Inventori barang')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">MASTER DATA</div>
<h1>Inventori barang</h1>
<p class="subtle mb-0">Kelola produk, harga, dan ketersediaan stok toko.</p>
</div>
<a class="btn btn-primary" href="{{ route('items.create') }}">
<i class="fa-solid fa-plus me-2">
</i> Tambah barang</a>
</div>
<div class="card">
<div class="card-body">
<div class="d-flex justify-content-between mb-4">
<h2>Daftar barang</h2>
<span class="badge badge-low">Stok ≤ 5 perlu restok</span>
</div>
<div class="table-responsive">
<table class="table" id="inventory-table" data-url="{{ route('items.data') }}" data-edit-url="{{ url('/items') }}">
<thead>
<tr>
<th>Kode</th>
<th>Nama barang</th>
<th>Kategori</th>
<th>Harga beli</th>
<th>Harga jual</th>
<th>Stok</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
</div>
@endsection
