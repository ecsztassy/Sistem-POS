<header class="topbar">
<div class="d-flex align-items-center gap-3">
<button type="button" class="btn btn-light mobile-toggle" aria-label="Buka menu" onclick="document.getElementById('sidebar').classList.toggle('open')">
<i class="fa-solid fa-bars">
</i>
</button>
<span class="subtle">Workspace <span class="mx-2 text-body-tertiary">/</span>
<span class="text-dark">@yield('title','Dashboard')</span>
</span>
</div>
<div class="d-flex gap-3 align-items-center">
<span class="small subtle d-none d-lg-block">
<i class="fa-regular fa-calendar me-2">
</i>{{ now()->format('d M Y') }}</span>
<div class="vr mx-1">
</div>
<a href="{{ auth()->user()->role==='admin'?route('profile.edit'):route('pos.index') }}" class="avatar" aria-label="Profil akun">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</a>
<div class="d-none d-sm-block">
<div class="small fw-semibold">{{ auth()->user()->name }}</div>
<div class="subtle" style="font-size:11px">{{ ucfirst(auth()->user()->role) }}</div>
</div>
</div>
</header>
