<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbillrajal extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 't_billrajal';
    protected $guarded = ["IDXBILL"];
    protected $fillable = ['IDXDAFTAR',  'TARIFRS', 'qty', 'status_tindakan'];

    public function pendaftaran()
    {
        return $this->hasOne(Tpendaftaran::class, 'idxdaftar', 'IDXDAFTAR');
    }
    
    public function tarif()
    {
        return $this->hasOne(Mtarif::class, 'kode_tindakan', 'KODETARIF');
    }
    public function bayarrajal()
    {
        return $this->hasOne(Tbayarrajal::class, 'nobill', 'NOBILL');
    }


}
