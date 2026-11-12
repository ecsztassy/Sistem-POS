@extends('layouts.app')
@section('title','Profil akun')
@section('content')
<div class="page-heading"><div><div class="eyebrow">AKUN SAYA</div><h1>Profil akun</h1><p class="subtle mb-0">Perbarui identitas dan keamanan akun Anda.</p></div></div>
<div class="row g-4">
    <div class="col-lg-6"><div class="card"><div class="card-body">
        <h2 class="mb-4">Informasi akun</h2>
        @if(session('status')==='profile-updated')<div class="alert alert-success">Profil disimpan.</div>@endif
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            @include('partials.field',['name'=>'name','label'=>'Nama lengkap','value'=>$user->name])
            @include('partials.field',['name'=>'username','label'=>'Username','value'=>$user->username])
            <button class="btn btn-primary">Simpan profil</button>
        </form>
    </div></div></div>
    <div class="col-lg-6"><div class="card"><div class="card-body">
        <h2 class="mb-4">Ubah kata sandi</h2>
        @if(session('status')==='password-updated')<div class="alert alert-success">Kata sandi diperbarui.</div>@endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf @method('PUT')
            @foreach(['current_password' => 'Kata sandi saat ini', 'password' => 'Kata sandi baru', 'password_confirmation' => 'Konfirmasi kata sandi'] as $name => $label)
                <div class="mb-3">
                    <label class="form-label" for="{{ $name }}">{{ $label }}</label>
                    <x-password-input :id="$name" :name="$name" :label="strtolower($label)"
                        :autocomplete="$name === 'current_password' ? 'current-password' : 'new-password'" required />
                    @error($name, 'updatePassword')
                        <div class="small text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
            <button class="btn btn-primary">Simpan kata sandi</button>
        </form>
    </div></div></div>
</div>
@endsection
