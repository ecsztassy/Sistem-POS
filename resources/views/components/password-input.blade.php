@props(['id', 'name', 'label' => 'kata sandi'])

<div class="position-relative" x-data="{ visible: false }">
    <input {{ $attributes->class(['form-control', 'pe-5']) }} id="{{ $id }}" name="{{ $name }}" type="password" :type="visible ? 'text' : 'password'">
    <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y px-3 subtle"
        @click="visible = !visible"
        aria-label="Tampilkan {{ $label }}"
        :aria-label="visible ? 'Sembunyikan {{ $label }}' : 'Tampilkan {{ $label }}'"
        aria-controls="{{ $id }}" aria-pressed="false" :aria-pressed="visible">
        <i class="fa-solid fa-eye" :class="visible ? 'fa-eye-slash' : 'fa-eye'" aria-hidden="true"></i>
    </button>
</div>
