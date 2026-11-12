<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:255'], 'address' => ['required', 'string', 'max:2000'], 'phone' => ['required', 'string', 'max:40'], 'footer_note' => ['nullable', 'string', 'max:1000']];
    }
}
