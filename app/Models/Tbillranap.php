<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbillranap extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 't_billranap';
    protected $guarded = ["IDXBILL"];

    public function pendaftaran()
    {
        return $this->hasOne(Tpendaftaran::class, 'idxdaftar', 'IDXDAFTAR');
    }
    public function tarif()
    {
        return $this->hasOne(Mtarif::class, 'kode_tindakan', 'KODETARIF');
    }
    public function bayarranap()
    {
        return $this->hasOne(Tbayarranap::class, 'nobill', 'NOBILL');
    }

}
