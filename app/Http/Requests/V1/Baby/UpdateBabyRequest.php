<?php

namespace App\Http\Requests\V1\Baby;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBabyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes','string','max:100'],
            'birth_date' => ['sometimes','date'],
            'photo' => ['nullable','string','max:255'],
            'birth_weight' => ['nullable','numeric','min:0'],
            'birth_height' => ['nullable','numeric','min:0'],
        ];
    }
}


