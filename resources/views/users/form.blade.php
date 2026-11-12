@extends('layouts.app')
@section('title',$user->exists?'Edit pengguna':'Tambah pengguna')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">AKSES WORKSPACE</div>
<h1>{{ $user->exists?'Edit pengguna':'Tambah pengguna' }}</h1>
<p class="subtle mb-0">Admin memiliki akses penuh. Kasir melayani transaksi.</p>
</div>
<a href="{{ route('users.index') }}" class="btn btn-light border">Kembali</a>
</div>
<div class="card" style="max-width:700px">
<div class="card-body">
<form method="POST" action="{{ $user->exists?route('users.update',$user):route('users.store') }}">@csrf @if($user->exists) @method('PUT') @endif @include('partials.field',['name'=>'name','label'=>'Nama lengkap','value'=>$user->name]) @include('partials.field',['name'=>'username','label'=>'Username','value'=>$user->username])<div class="mb-3">
<label for="role" class="form-label">Peran</label>
<select class="form-select" id="role" name="role">@foreach(['kasir','admin'] as $role)<option value="{{ $role }}" @selected(old('role',$user->role)===$role)>{{ ucfirst($role) }}</option>@endforeach</select>
</div>
<hr class="my-4">@if($user->exists)<p class="small subtle">Kosongkan kata sandi jika tidak ingin mengubahnya.</p>@endif @include('partials.field',['name'=>'password','label'=>'Kata sandi (minimal 8 karakter)','type'=>'password','required'=>!$user->exists]) @include('partials.field',['name'=>'password_confirmation','label'=>'Konfirmasi kata sandi','type'=>'password','required'=>!$user->exists])<button class="btn btn-primary">Simpan pengguna</button>
</form>
</div>
</div>
@endsection
