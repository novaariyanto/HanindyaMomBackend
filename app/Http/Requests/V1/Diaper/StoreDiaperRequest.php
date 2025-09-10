<?php

namespace App\Http\Requests\V1\Diaper;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiaperRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'baby_id' => ['required','string','size:36'],
            'type' => ['required','in:pipis,pup,campuran'],
            'color' => ['nullable','string','max:50'],
            'texture' => ['nullable','string','max:50'],
            'time' => ['required','date'],
            'notes' => ['nullable','string'],
        ];
    }
}


