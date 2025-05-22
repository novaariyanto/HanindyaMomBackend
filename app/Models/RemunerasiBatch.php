<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RemunerasiBatch extends Model
{
    use HasFactory;

    protected $table = 'remunerasi_batch';
    
    protected $fillable = [
        'nama_batch',
        'tahun',
        'status'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function sources(): HasMany
    {
        return $this->hasMany(RemunerasiSource::class, 'batch_id');
    }
} 