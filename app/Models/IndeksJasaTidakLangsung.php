<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndeksJasaTidakLangsung extends Model
{
    protected $table = 'indeks_jasa_tidak_langsung';
    protected $fillable = ['nama_indeks', 'nilai', 'kategori'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_indeks_jtl');
    }
} 