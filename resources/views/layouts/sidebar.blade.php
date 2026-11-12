<aside class="sidebar" id="sidebar">
<button type="button" class="btn btn-sm btn-light mobile-toggle position-absolute top-0 end-0 m-2" aria-label="Tutup menu" onclick="document.getElementById('sidebar').classList.remove('open')"><i class="fa-solid fa-xmark"></i></button>
<a class="brand" href="{{ url('/') }}">
<img src="{{ asset('favicon.svg') }}" width="42" height="42" alt="">
<span>ritel<span style="color:#16765a">.</span>
<small>POINT OF SALE</small>
</span>
</a>
<div class="nav-label">WORKSPACE</div>
<nav>
@if(auth()->user()->role === 'admin')<a class="side-link {{ request()->routeIs('dashboard')?'active':'' }}" href="{{ route('dashboard') }}">
<i class="fa-solid fa-chart-pie">
</i> Dashboard</a>@endif
<a class="side-link {{ request()->routeIs('pos.*')?'active':'' }}" href="{{ route('pos.index') }}">
<i class="fa-solid fa-cash-register">
</i> Kasir / POS</a>
<a class="side-link {{ request()->routeIs('sales.*')?'active':'' }}" href="{{ route('sales.daily') }}">
<i class="fa-solid fa-receipt">
</i> Penjualan hari ini</a>
@if(auth()->user()->role === 'admin')<div class="nav-label">KELOLA TOKO</div>@foreach([['items.*','items.index','fa-box','Inventori barang'],['categories.*','categories.index','fa-layer-group','Kategori'],['reports.*','reports.index','fa-chart-simple','Laporan penjualan'],['users.*','users.index','fa-user-group','Pengguna'],['settings.*','settings.edit','fa-sliders','Pengaturan toko']] as [$pattern,$route,$icon,$label])<a class="side-link {{ request()->routeIs($pattern)?'active':'' }}" href="{{ route($route) }}">
<i class="fa-solid {{ $icon }}">
</i> {{ $label }}</a>@endforeach @endif</nav>
<div class="mt-auto pt-5">
<div class="p-3 rounded-3" style="background:#f5f8f6">
<i class="fa-solid fa-circle-check text-success me-2">
</i>
<strong class="small">Siap melayani</strong>
<p class="small subtle mb-0 mt-2">Semua transaksi tercatat dengan aman.</p>
</div>
<form method="POST" action="{{ route('logout') }}" class="mt-3">@csrf<button class="side-link border-0 bg-transparent w-100">
<i class="fa-solid fa-arrow-right-from-bracket">
</i> Keluar</button>
</form>
</div>
</aside>
