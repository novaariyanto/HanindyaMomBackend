<?php

namespace App\Http\Requests\V1\Diaper;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiaperRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['sometimes','in:pipis,pup,campuran'],
            'color' => ['nullable','string','max:50'],
            'texture' => ['nullable','string','max:50'],
            'time' => ['sometimes','date'],
            'notes' => ['nullable','string'],
        ];
    }
}


