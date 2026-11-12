@extends('layouts.app')
@section('title','Pengaturan toko')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">PREFERENSI</div>
<h1>Pengaturan toko</h1>
<p class="subtle mb-0">Informasi ini akan ditampilkan pada struk pelanggan.</p>
</div>
</div>
<div class="row g-4">
<div class="col-lg-8">
<div class="card">
<div class="card-body">
<h2 class="mb-4">Identitas toko</h2>
<form action="{{ route('settings.update') }}" method="POST">@csrf @method('PUT') @include('partials.field',['name'=>'name','label'=>'Nama toko','value'=>$store->name])<div class="mb-3">
<label for="address" class="form-label">Alamat toko</label>
<textarea id="address" class="form-control" name="address" rows="3" required>{{ old('address',$store->address) }}</textarea>
</div>@include('partials.field',['name'=>'phone','label'=>'Nomor telepon','value'=>$store->phone])<div class="mb-4">
<label class="form-label" for="footer_note">Pesan di akhir struk</label>
<textarea class="form-control" id="footer_note" name="footer_note" rows="3">{{ old('footer_note',$store->footer_note) }}</textarea>
</div>
<button class="btn btn-primary">
<i class="fa-regular fa-floppy-disk me-2">
</i> Simpan pengaturan</button>
</form>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="card">
<div class="card-body">
<span class="stat-icon mb-3">
<i class="fa-solid fa-receipt">
</i>
</span>
<h2>Sentuhan personal</h2>
<p class="subtle small mb-0">Tambahkan nama dan kontak toko agar pelanggan mudah menemukan Anda kembali. Pesan singkat pada struk membuat setiap pembelian terasa lebih dekat.</p>
</div>
</div>
</div>
</div>
@endsection
