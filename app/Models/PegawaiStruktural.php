<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PegawaiStruktural extends Model
{
    use SoftDeletes;
    
    protected $table = 'pegawai_struktural';
    
    protected $fillable = [
        'pegawai_id',
        'jasa_id',
        'nilai'
    ];

    protected $casts = [
        'nilai' => 'decimal:2'
    ];
    
    protected $dates = ['deleted_at'];

    // Relasi ke Pegawai
    public function pegawai()
    {
        return $this->belongsTo(IndeksPegawai::class, 'pegawai_id');
    }

    // Relasi ke IndeksJasaLangsungNonMedis
    public function jasa()
    {
        return $this->belongsTo(IndeksStruktural::class, 'jasa_id');
    }
} 