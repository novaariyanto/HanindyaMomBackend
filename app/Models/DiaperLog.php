<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiaperLog extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'diaper_logs';

    protected $fillable = [
        'id',
        'baby_id',
        'type',
        'color',
        'texture',
        'time',
        'notes',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function baby(): BelongsTo
    {
        return $this->belongsTo(BabyProfile::class, 'baby_id');
    }
}


