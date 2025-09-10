<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BabyProfile extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'baby_profiles';

    protected $fillable = [
        'id',
        'user_uuid',
        'name',
        'birth_date',
        'photo',
        'birth_weight',
        'birth_height',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'birth_weight' => 'decimal:2',
        'birth_height' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function feedingLogs(): HasMany
    {
        return $this->hasMany(FeedingLog::class, 'baby_id');
    }

    public function diaperLogs(): HasMany
    {
        return $this->hasMany(DiaperLog::class, 'baby_id');
    }

    public function sleepLogs(): HasMany
    {
        return $this->hasMany(SleepLog::class, 'baby_id');
    }

    public function growthLogs(): HasMany
    {
        return $this->hasMany(GrowthLog::class, 'baby_id');
    }

    public function vaccineSchedules(): HasMany
    {
        return $this->hasMany(VaccineSchedule::class, 'baby_id');
    }
}


