<?php

namespace App\Http\Requests\V1\Vaccine;

use Illuminate\Foundation\Http\FormRequest;

class StoreVaccineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'baby_id' => ['required','string','size:36'],
            'vaccine_name' => ['required','string','max:150'],
            'schedule_date' => ['required','date'],
            'status' => ['nullable','in:scheduled,done'],
            'notes' => ['nullable','string'],
        ];
    }
}


