<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    @include('partials.favicon')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Akun' }} ? Ritel POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="auth-shell">
        <div class="auth-container">
            <a class="brand justify-content-center mb-4" href="{{ url('/') }}"><img src="{{ asset('favicon.svg') }}" width="42" height="42" alt=""> ritel.</a>
            <div class="card auth-card">
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="status">{{ session('status') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </div>
    </main>
</body>
</html>
