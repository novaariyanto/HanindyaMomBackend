<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndeksStruktural extends Model
{
    protected $table = 'indeks_struktural';
    protected $fillable = ['nama_jabatan', 'nilai'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_jabatan_struktural');
    }
} 