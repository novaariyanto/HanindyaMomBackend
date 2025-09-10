<?php

namespace App\Http\Requests\V1\Sleep;

use Illuminate\Foundation\Http\FormRequest;

class StoreSleepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'baby_id' => ['required','string','size:36'],
            'start_time' => ['required','date'],
            'end_time' => ['required','date','after:start_time'],
            'notes' => ['nullable','string'],
        ];
    }
}


