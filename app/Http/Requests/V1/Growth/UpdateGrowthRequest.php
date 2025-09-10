<?php

namespace App\Http\Requests\V1\Growth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrowthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['sometimes','date'],
            'weight' => ['sometimes','numeric','min:0'],
            'height' => ['sometimes','numeric','min:0'],
            'head_circumference' => ['nullable','numeric','min:0'],
        ];
    }
}


