<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['q' => ['nullable', 'string', 'max:255'], 'ids' => ['nullable', 'array', 'max:100'], 'ids.*' => ['integer', 'min:1'], 'draw' => ['nullable', 'integer', 'min:0'], 'start' => ['nullable', 'integer', 'min:0'], 'length' => ['nullable', 'integer', 'min:1', 'max:100'], 'search.value' => ['nullable', 'string', 'max:255'], 'start_date' => ['nullable', 'date_format:Y-m-d'], 'end_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:start_date']];
    }
}
