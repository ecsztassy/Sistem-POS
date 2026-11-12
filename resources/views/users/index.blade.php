@extends('layouts.app')
@section('title','Pengguna')
@section('content')
<div class="page-heading">
<div>
<div class="eyebrow">AKSES WORKSPACE</div>
<h1>Pengguna</h1>
<p class="subtle mb-0">Kelola akun dan peran tim toko Anda.</p>
</div>
<a class="btn btn-primary" href="{{ route('users.create') }}">
<i class="fa-solid fa-plus me-2">
</i> Tambah pengguna</a>
</div>
<div class="card">
<div class="card-body">
<div class="table-responsive">
<table class="table datatable">
<thead>
<tr>
<th>Nama</th>
<th>Username</th>
<th>Peran</th>
<th>Transaksi</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>@foreach($users as $user)<tr>
<td class="fw-semibold">{{ $user->name }}</td>
<td>{{ $user->username }}</td>
<td>
<span class="badge badge-soft">{{ ucfirst($user->role) }}</span>
</td>
<td>{{ $user->transactions_count }}</td>
<td class="text-nowrap">
<a class="btn btn-sm btn-light border" href="{{ route('users.edit',$user) }}">Edit</a>@if($user->id!==auth()->id() && $user->transactions_count===0)<form method="POST" action="{{ route('users.destroy',$user) }}" class="d-inline" data-confirm="Hapus akun pengguna ini?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button>
</form>@endif</td>
</tr>@endforeach</tbody>
</table>
</div>
</div>
</div>
@endsection
