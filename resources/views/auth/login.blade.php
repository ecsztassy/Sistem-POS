<x-guest-layout>
    <x-slot:title>Masuk</x-slot:title>
    <div class="eyebrow">SELAMAT DATANG KEMBALI</div>
    <h1>Masuk ke workspace</h1>
    <p class="subtle mb-4">Gunakan akun Anda untuk mulai mengelola toko.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="username" class="form-label">Username</label>
        <input class="form-control mb-3" id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="username" required autofocus>

        <label class="form-label" for="password">Kata Sandi</label>
        <div class="mb-3">
            <x-password-input id="password" name="password" autocomplete="current-password" required />
        </div>

        <div class="d-flex justify-content-between gap-2 mb-4 small">
            <label for="remember">
                <input type="checkbox" id="remember" name="remember" class="form-check-input me-1" @checked(old('remember'))> Ingat saya
            </label>
            <span class="subtle">Lupa kata sandi? Hubungi admin.</span>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk <i class="fa-solid fa-arrow-right ms-2" aria-hidden="true"></i></button>
    </form>

    <p class="small subtle mt-4 mb-0 text-center">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
</x-guest-layout>
