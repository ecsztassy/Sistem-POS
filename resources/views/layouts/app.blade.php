<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
@include('partials.favicon')
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Dashboard') · Ritel POS</title>@vite(['resources/css/app.css','resources/js/app.js'])</head>
<body>@include('layouts.sidebar')<div class="workspace">@include('layouts.header')<main class="content">@if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif @if($errors->any())<div class="alert alert-danger" role="alert">
<strong>Periksa kembali isian Anda.</strong>
<ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>@endif @yield('content'){{ $slot ?? '' }}</main>@include('layouts.footer')</div>@stack('scripts')</body>
</html>
