<?php

namespace App\Http\Requests\V1\Feeding;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['sometimes','in:asi_left,asi_right,formula,pump'],
            'start_time' => ['sometimes','date'],
            'duration_minutes' => ['sometimes','integer','min:1'],
            'notes' => ['nullable','string'],
        ];
    }
}


