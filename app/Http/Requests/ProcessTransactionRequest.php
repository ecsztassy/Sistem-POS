<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role, ['admin', 'kasir']);
    }

    public function rules(): array
    {
        return [
            'checkout_token' => ['required', 'uuid'], 'pay_amount' => ['required', 'integer', 'min:0', 'max:1000000000000000'],
            'notes' => ['nullable', 'string', 'max:2000'], 'items' => ['required', 'array', 'min:1', 'max:100'],
            'items.*.item_id' => ['required', 'integer', 'distinct'], 'items.*.qty' => ['required', 'integer', 'min:1', 'max:1000000'],
        ];
    }
}
