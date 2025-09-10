<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VaccineSchedule extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'vaccine_schedules';

    protected $fillable = [
        'id',
        'baby_id',
        'vaccine_name',
        'schedule_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'schedule_date' => 'date',
    ];

    public function baby(): BelongsTo
    {
        return $this->belongsTo(BabyProfile::class, 'baby_id');
    }
}


