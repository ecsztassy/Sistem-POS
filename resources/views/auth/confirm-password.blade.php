<x-guest-layout>
    <h1 class="fs-4">Konfirmasi kata sandi</h1>
    <p class="subtle small mb-4">Masukkan kata sandi untuk melanjutkan.</p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        @include('partials.field',['name'=>'password','label'=>'Kata sandi','type'=>'password'])
        <button class="btn btn-primary w-100">Konfirmasi</button>
    </form>
</x-guest-layout>
