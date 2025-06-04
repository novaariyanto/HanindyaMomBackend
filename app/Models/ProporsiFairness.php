<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProporsiFairness extends Model
{
    protected $table = 'proporsi_fairness';
    
    protected $fillable = [
        'groups',
        'jenis',
        'grade',
        'ppa',
        'value',
        'sumber',
        'flag',
        'del'
    ];

    protected $casts = [
        'value' => 'decimal:3',
        'del' => 'boolean'
    ];

    public function gradeRelation()
    {
        return $this->belongsTo(Grade::class, 'grade', 'grade');
    }

    public function sumberRelation()
    {
        return $this->belongsTo(Sumber::class, 'sumber', 'name');
    }
} 