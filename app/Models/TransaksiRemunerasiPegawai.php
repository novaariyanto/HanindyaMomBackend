<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiRemunerasiPegawai extends Model
{
    protected $table = 'transaksi_remunerasi_pegawai';
    protected $fillable = [
        'id_remunerasi_batch',
        'id_remunerasi_source',
        'indeks_cluster_1',
        'indeks_cluster_2',
        'indeks_cluster_3',
        'indeks_cluster_4',
        'nilai_indeks_1',
        'nilai_indeks_2',
        'nilai_indeks_3',
        'nilai_indeks_4',
        'nilai_remunerasi',
        'id_pegawai'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function remunerasiBatch()
    {
        return $this->belongsTo(RemunerasiBatch::class, 'id_remunerasi_batch');
    }

    public function remunerasiSource()
    {
        return $this->belongsTo(RemunerasiSource::class, 'id_remunerasi_source');
    }
} 