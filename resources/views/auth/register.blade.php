<x-guest-layout>
    <x-slot:title>Daftar</x-slot:title>
    <div class="eyebrow">MULAI BERSAMA RITEL</div>
    <h1>Buat akun Anda</h1>
    <p class="subtle mb-4">Daftar untuk mulai melayani transaksi toko.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="name" class="form-label">Nama Lengkap</label>
        <input class="form-control mb-3" id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="255" required autofocus>

        <label for="username" class="form-label">Username</label>
        <input class="form-control mb-3" id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="username" maxlength="255" required>

        <label for="password" class="form-label">Kata Sandi</label>
        <x-password-input id="password" name="password" autocomplete="new-password" minlength="8" aria-describedby="password-help" required />
        <p id="password-help" class="small subtle mt-2 mb-3">Gunakan minimal 8 karakter.</p>

        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        <div class="mb-4">
            <x-password-input id="password_confirmation" name="password_confirmation" label="konfirmasi kata sandi" autocomplete="new-password" minlength="8" required />
        </div>

        <button type="submit" class="btn btn-primary w-100">Daftar</button>
    </form>

    <p class="small subtle mt-4 mb-0 text-center">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
</x-guest-layout>
