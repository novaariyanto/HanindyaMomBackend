<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tradiologi extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 't_radiologi';
    protected $guarded = ["IDXORDERRAD"];

    public function pendaftaran()
    {
        return $this->hasOne(Tpendaftaran::class, 'idxdaftar', 'IDXDAFTAR');
    }


}
