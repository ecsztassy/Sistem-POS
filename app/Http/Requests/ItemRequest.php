<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'item_code' => ['required', 'string', 'max:80', Rule::unique('items')->ignore($this->route('item'))],
            'category_id' => ['required', Rule::exists('categories', 'id')->whereNull('deleted_at')],
            'name' => ['required', 'string', 'max:255'], 'unit' => ['required', 'string', 'max:30'],
            'buy_price' => ['required', 'integer', 'min:0', 'max:1000000000'],
            'sell_price' => ['required', 'integer', 'min:0', 'max:1000000000'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
        ];
    }
}
