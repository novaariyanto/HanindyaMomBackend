<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrowthLog extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'growth_logs';

    protected $fillable = [
        'id',
        'baby_id',
        'date',
        'weight',
        'height',
        'head_circumference',
    ];

    protected $casts = [
        'date' => 'date',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'head_circumference' => 'decimal:2',
    ];

    public function baby(): BelongsTo
    {
        return $this->belongsTo(BabyProfile::class, 'baby_id');
    }
}


