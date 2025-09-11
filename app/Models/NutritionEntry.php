<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionEntry extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'nutrition_entries';

    protected $fillable = [
        'id',
        'baby_id',
        'time',
        'title',
        'photo_path',
        'notes',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}


