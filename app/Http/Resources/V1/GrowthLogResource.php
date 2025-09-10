<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GrowthLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'baby_id' => $this->baby_id,
            'date' => optional($this->date)->toDateString(),
            'weight' => (double) $this->weight,
            'height' => (double) $this->height,
            'head_circumference' => (double) $this->head_circumference,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}


