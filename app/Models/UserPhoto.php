<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class UserPhoto extends Model
{
    //
    protected $fillable = [
        'uuid',
        'path',
        'user_id',
        'face_landmarks',
    ];

    // Generate UUID secara otomatis saat membuat record baru
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
