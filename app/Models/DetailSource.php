<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSource extends Model
{
    protected $table = 'detail_source';
    
    protected $fillable = [
        'no_sep',
        'tgl_verifikasi',
        'jenis',
        'status',
        'id_remunerasi_source',
        'biaya_riil_rs',
        'biaya_diajukan',
        'biaya_disetujui',
        'idxdaftar',
        'total_remunerasi'
    ];

    protected $casts = [
        'tgl_verifikasi' => 'date',
        'biaya_riil_rs' => 'decimal:2',
        'biaya_diajukan' => 'decimal:2',
        'biaya_disetujui' => 'decimal:2'
    ];

    public function remunerasiSource()
    {
        return $this->belongsTo(RemunerasiSource::class, 'id_remunerasi_source');
    }
} 