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
        'value' => 'decimal:2',
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

    public static function getDataForExport($filters = [])
    {
        $query = self::where('del', false);
        
        if (!empty($filters['grade'])) {
            $query->where('grade', $filters['grade']);
        }
        
        if (!empty($filters['sumber'])) {
            $query->where('sumber', $filters['sumber']);
        }
        
        if (!empty($filters['groups'])) {
            $query->where('groups', $filters['groups']);
        }

        return $query->get();
    }
} 