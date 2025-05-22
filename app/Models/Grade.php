<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grade';
    
    protected $fillable = [
        'grade',
        'persentase',
        'persentase_top'
    ];

    protected $casts = [
        'persentase' => 'decimal:2',
        'persentase_top' => 'decimal:2'
    ];
} 