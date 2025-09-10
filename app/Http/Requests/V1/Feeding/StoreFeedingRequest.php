<?php

namespace App\Http\Requests\V1\Feeding;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'baby_id' => ['required','string','size:36'],
            'type' => ['required','in:asi_left,asi_right,formula,pump'],
            'start_time' => ['required','date'],
            'duration_minutes' => ['required','integer','min:1'],
            'notes' => ['nullable','string'],
        ];
    }
}


