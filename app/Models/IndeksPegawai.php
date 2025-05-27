<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndeksPegawai extends Model
{
    protected $table = 'indeks_pegawai';
    
    protected $fillable = [
        'nama',
        'nip',
        'tmt_cpns',
        'tmt_di_rs',
        'masa_kerja_di_rs',
        'indeks_masa_kerja',
        'kualifikasi_pendidikan',
        'indeks_kualifikasi_pendidikan',
        'indeks_resiko',
        'indeks_emergency',
        'jabatan',
        'indeks_posisi_unit_kerja',
        'ruang',
        'indeks_jabatan_tambahan',
        'indeks_performa',
        'total'
    ];

    protected $casts = [
        'tmt_cpns' => 'date',
        'tmt_di_rs' => 'date',
        'indeks_masa_kerja' => 'decimal:2',
        'total' => 'decimal:2'
    ];
}
