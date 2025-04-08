<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiMutasi extends Model
{
    //
    protected $connection = 'eprofile';
    protected $table = 'pegawai_mutasi';
    protected $fillable = ['pegawai_id', 'unit_kerja_id', 'tahun_masuk', 'tahun_keluar', 'status'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    
}
