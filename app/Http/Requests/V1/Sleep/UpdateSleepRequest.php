<?php

namespace App\Http\Requests\V1\Sleep;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSleepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_time' => ['sometimes','date'],
            'end_time' => ['sometimes','date','after:start_time'],
            'notes' => ['nullable','string'],
        ];
    }
}


