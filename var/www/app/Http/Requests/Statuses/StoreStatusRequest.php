<?php

namespace App\Http\Requests\Statuses;

use Illuminate\Foundation\Http\FormRequest;

class StoreStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:25',
            'order' => 'nullable|integer',
        ];
    }
}
