@extends('layouts.app')
@section('title','Kategori')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">MASTER DATA</div>
<h1>Kategori barang</h1>
<p class="subtle mb-0">Kelompokkan produk agar inventori mudah dikelola.</p>
</div>
</div>
<div class="row g-4">
<div class="col-xl-8">
<div class="card">
<div class="card-body">
<h2 class="mb-4">Semua kategori <span class="badge badge-soft ms-2">{{ $categories->count() }}</span>
</h2>
<div class="table-responsive">
<table class="table datatable">
<thead>
<tr>
<th>Kategori</th>
<th>Barang aktif</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>@foreach($categories as $category)<tr>
<td>
<form id="category-{{ $category->id }}" action="{{ route('categories.update',$category) }}" method="POST">@csrf @method('PUT')<input aria-label="Nama kategori" class="form-control" name="name" value="{{ $category->name }}" required maxlength="255">
</form>
</td>
<td>{{ $category->items_count }} barang</td>
<td class="text-nowrap">
<button form="category-{{ $category->id }}" class="btn btn-sm btn-outline-primary" aria-label="Simpan kategori">
<i class="fa-solid fa-check">
</i>
</button>
<form class="d-inline" action="{{ route('categories.destroy',$category) }}" method="POST" data-confirm="Arsipkan kategori beserta semua barang di dalamnya?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" aria-label="Arsipkan kategori">
<i class="fa-regular fa-trash-can">
</i>
</button>
</form>
</td>
</tr>@endforeach</tbody>
</table>
</div>
</div>
</div>
</div>
<div class="col-xl-4">
<div class="card">
<div class="card-body">
<h2>Tambah kategori</h2>
<p class="subtle small mb-4">Buat kelompok baru untuk produk Anda.</p>
<form action="{{ route('categories.store') }}" method="POST">@csrf @include('partials.field',['name'=>'name','label'=>'Nama kategori'])<button class="btn btn-primary w-100">
<i class="fa-solid fa-plus me-2">
</i> Tambah kategori</button>
</form>
</div>
</div>
</div>
</div>
@endsection
