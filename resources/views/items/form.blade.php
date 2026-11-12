@extends('layouts.app')
@section('title',$item->exists?'Edit barang':'Tambah barang')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">INVENTORI</div>
<h1>{{ $item->exists?'Edit barang':'Tambah barang' }}</h1>
<p class="subtle mb-0">Lengkapi informasi produk untuk mulai berjualan.</p>
</div>
<a class="btn btn-light border" href="{{ route('items.index') }}">Kembali</a>
</div>
<div class="card" style="max-width:900px">
<div class="card-body">
<form method="POST" action="{{ $item->exists?route('items.update',$item):route('items.store') }}">@csrf @if($item->exists) @method('PUT') @endif<h2 class="mb-4">Informasi barang</h2>
<div class="row">
<div class="col-md-6">@include('partials.field',['name'=>'item_code','label'=>'Kode barang','value'=>$item->item_code])</div>
<div class="col-md-6">@include('partials.field',['name'=>'name','label'=>'Nama barang','value'=>$item->name])</div>
<div class="col-md-6">
<div class="mb-3">
<label class="form-label" for="category_id">Kategori</label>
<select class="form-select" id="category_id" name="category_id" required>
<option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$item->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select>@if($categories->isEmpty())<a class="small" href="{{ route('categories.index') }}">Tambahkan kategori terlebih dahulu.</a>@endif</div>
</div>
<div class="col-md-6">@include('partials.field',['name'=>'unit','label'=>'Satuan','value'=>$item->unit??'pcs'])</div>
</div>
<hr class="my-4">
<h2 class="mb-4">Harga & stok</h2>
<div class="row">@foreach(['buy_price'=>'Harga beli (Rp)','sell_price'=>'Harga jual (Rp)','stock'=>'Stok tersedia'] as $field=>$label)<div class="col-md-4">@include('partials.field',['name'=>$field,'label'=>$label,'type'=>'number','value'=>$item->$field??0])</div>@endforeach</div>
<div class="mt-4 text-end">
<button class="btn btn-primary">
<i class="fa-regular fa-floppy-disk me-2">
</i> Simpan barang</button>
</div>
</form>
</div>
</div>
@endsection
