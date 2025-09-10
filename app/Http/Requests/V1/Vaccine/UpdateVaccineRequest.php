<?php

namespace App\Http\Requests\V1\Vaccine;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVaccineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vaccine_name' => ['sometimes','string','max:150'],
            'schedule_date' => ['sometimes','date'],
            'status' => ['sometimes','in:scheduled,done'],
            'notes' => ['nullable','string'],
        ];
    }
}


