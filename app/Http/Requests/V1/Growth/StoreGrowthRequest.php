<?php

namespace App\Http\Requests\V1\Growth;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrowthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'baby_id' => ['required','string','size:36'],
            'date' => ['required','date'],
            'weight' => ['required','numeric','min:0'],
            'height' => ['required','numeric','min:0'],
            'head_circumference' => ['nullable','numeric','min:0'],
        ];
    }
}


