<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndeksJasaLangsungNonMedis extends Model
{
    protected $table = 'indeks_jasa_langsung_non_medis';
    protected $fillable = ['nama_jabatan', 'nilai'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_indeks_jl_non_medis');
    }
} 