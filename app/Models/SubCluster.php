<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCluster extends Model
{
    use HasFactory;

    protected $table = 'sub_cluster';

    protected $fillable = [
        'nama_ppa',
        'cluster',
        'jenis'
    ];

    // Contoh relasi many-to-many ke Pegawai (jika pakai pivot pegawai_ppa)
    // public function pegawais()
    // {
    //     return $this->belongsToMany(Pegawai::class, 'pegawai_ppa', 'ppa_id', 'pegawai_id')
    //                 ->withPivot('bulan');
    // }
}
