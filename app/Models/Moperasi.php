<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moperasi extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 't_operasi';
    protected $guarded = ["id_operasi"];

    public function pendaftaran()
    {
        return $this->hasOne(Tpendaftaran::class, 'idxdaftar', 'IDXDAFTAR');
    }


}
