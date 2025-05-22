<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemunerasiSource extends Model
{
    use HasFactory;

    protected $table = 'remunerasi_source';
    
   protected $guarded = ['id'];

    protected $casts = [
        'tgl_masuk' => 'datetime',
        'tgl_keluar' => 'datetime',
        'total_biaya' => 'decimal:2'
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(RemunerasiBatch::class, 'batch_id');
    }

    public function detailSources()
    {
        return $this->hasMany(DetailSource::class, 'remunerasi_source_id');
    }
    public function pembagianKlaim()
    {
        return $this->hasMany(PembagianKlaim::class, 'remunerasi_source_id');
    }
} 