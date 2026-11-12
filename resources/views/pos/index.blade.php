@extends('layouts.app')
@section('title','Kasir / POS')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">POINT OF SALE</div>
<h1>Transaksi baru</h1>
<p class="subtle mb-0">Pilih barang, terima pembayaran, selesai.</p>
</div>
<span class="badge badge-soft">
<i class="fa-solid fa-circle me-2" style="font-size:6px">
</i> Kasir aktif</span>
</div>
<div x-data="posCart" data-search-url="{{ route('pos.items') }}" data-old-paid="{{ old('pay_amount',0) }}" data-old-items="{{ json_encode(old('items',[])) }}" class="row g-4" id="pos-app">
<div class="col-lg-7 col-xl-8">
<div class="card mb-3">
<div class="card-body py-3">
<label class="visually-hidden" for="product-search">Cari barang</label>
<div class="input-group">
<span class="input-group-text bg-white border-end-0">
<i class="fa-solid fa-magnifying-glass subtle">
</i>
</span>
<input id="product-search" class="form-control border-start-0" placeholder="Cari nama atau kode barang..." x-model="search" x-on:input.debounce.250ms="loadProducts()" x-on:keydown.enter.prevent="addFirst()" autofocus>
</div>
</div>
</div>
<div class="d-flex justify-content-between small mb-3">
<span class="fw-semibold">Katalog barang</span>
<span class="subtle" x-text="loading?'Memuat...':products.length+' barang ditampilkan'">
</span>
</div>
<div class="alert alert-danger" x-show="error" x-text="error" x-cloak role="alert">
</div>
<div class="product-grid">
<template x-for="item in products" :key="item.id">
<button type="button" class="product" x-on:click="add(item)" :disabled="quantity(item.id)>=item.stock">
<div class="d-flex justify-content-between">
<div class="product-symbol">
<i class="fa-solid fa-box">
</i>
</div>
<span class="subtle" style="font-size:10px" x-text="item.stock+' '+item.unit">
</span>
</div>
<div class="subtle mb-1" style="font-size:10px" x-text="item.item_code">
</div>
<div class="fw-semibold mb-3" x-text="item.name">
</div>
<div style="color:#16765a" class="fw-bold" x-text="money(item.sell_price)">
</div>
</button>
</template>
</div>
<div class="empty-state" x-show="!loading && !products.length" x-cloak>
<i class="fa-solid fa-box-open fs-2 mb-3">
</i>
<p>Barang tidak ditemukan atau stok habis.</p>
</div>
</div>
<div class="col-lg-5 col-xl-4">
<form method="POST" action="{{ route('pos.checkout') }}" class="card cart-panel" x-on:submit="submit($event)">@csrf<input type="hidden" name="checkout_token" value="{{ old('checkout_token',(string) Illuminate\Support\Str::uuid()) }}">
<div class="card-body">
<div class="d-flex align-items-center justify-content-between mb-3">
<h2 class="mb-0">
<i class="fa-solid fa-basket-shopping me-2 text-success">
</i> Keranjang</h2>
<button class="btn btn-sm btn-light" type="button" x-on:click="clear()" :disabled="!cart.length">Kosongkan</button>
</div>
<div class="empty-state" x-show="!cart.length">
<i class="fa-solid fa-basket-shopping fs-2 mb-3 opacity-50">
</i>
<p class="mb-0">Keranjang masih kosong</p>
<small>Pilih barang untuk mulai transaksi.</small>
</div>
<template x-for="(line,index) in cart" :key="line.id">
<div class="cart-line">
<input type="hidden" :name="'items['+index+'][item_id]'" :value="line.id">
<div class="d-flex justify-content-between gap-2">
<div>
<div class="fw-semibold small" x-text="line.name">
</div>
<small class="subtle" x-text="money(line.sell_price)">
</small>
</div>
<button class="btn btn-sm text-danger p-1" type="button" :aria-label="'Hapus '+line.name" x-on:click="remove(line.id)">
<i class="fa-regular fa-trash-can">
</i>
</button>
</div>
<div class="d-flex justify-content-between align-items-center mt-2">
<div class="input-group input-group-sm" style="width:126px">
<button class="btn btn-light border" type="button" x-on:click="adjust(line,-1)" aria-label="Kurangi jumlah">−</button>
<input type="number" class="form-control text-center p-1" :name="'items['+index+'][qty]'" x-model.number="line.qty" min="1" :max="line.stock" step="1" required :aria-label="'Jumlah '+line.name">
<button class="btn btn-light border" type="button" x-on:click="adjust(line,1)" aria-label="Tambah jumlah">+</button>
</div>
<strong class="small" x-text="money(line.qty*line.sell_price)">
</strong>
</div>
</div>
</template>
<div class="d-flex justify-content-between my-4 align-items-center">
<span class="fw-semibold">Total belanja</span>
<strong class="fs-4" x-text="money(total)">
</strong>
</div>
<label class="form-label" for="pay_amount">Uang diterima (Rp)</label>
<input type="number" class="form-control mb-2" id="pay_amount" name="pay_amount" x-model.number="paid" min="0" step="1" max="1000000000000000" required placeholder="0">
<div class="d-flex gap-2 mb-3">
<button type="button" class="btn btn-sm btn-light border" x-on:click="paid=total">Uang pas</button>
<button type="button" class="btn btn-sm btn-light border" x-on:click="paid=Math.ceil(total/50000)*50000">Bulatkan 50rb</button>
</div>
<div class="d-flex justify-content-between p-3 rounded-3 mb-3" style="background:#eef5f0">
<span>Kembalian</span>
<strong :class="paid<total?'text-danger':'text-success'" x-text="money(Math.max(0,paid-total))">
</strong>
</div>
<label class="form-label" for="notes">Catatan <span class="subtle fw-normal">(opsional)</span>
</label>
<input id="notes" class="form-control mb-3" name="notes" maxlength="2000" value="{{ old('notes') }}" placeholder="Tambahkan catatan...">
<button class="btn btn-primary w-100" :disabled="!valid || busy">
<i class="fa-solid fa-check me-2">
</i>
<span x-text="busy?'Menyimpan...':'Proses pembayaran'">
</span>
</button>
<p class="subtle text-center mt-3 mb-0" style="font-size:10px">
<i class="fa-solid fa-lock me-1">
</i> Periksa pembayaran sebelum menyelesaikan transaksi.</p>
</div>
</form>
</div>
</div>
@endsection
