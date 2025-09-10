<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SleepLog extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'sleep_logs';

    protected $fillable = [
        'id',
        'baby_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    public function baby(): BelongsTo
    {
        return $this->belongsTo(BabyProfile::class, 'baby_id');
    }
}


