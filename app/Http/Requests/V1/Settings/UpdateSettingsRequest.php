<?php

namespace App\Http\Requests\V1\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'timezone' => ['required','string','max:100'],
            'unit' => ['required','in:ml,oz'],
            'notifications' => ['required','boolean'],
        ];
    }
}


