<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbpjs extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 't_bpjs';
    protected $guarded = ["id"];

    public function pendaftaran()
    {
        return $this->hasOne(Tpendaftaran::class, 'idxdaftar', 'IDXDAFTAR');
    }


}
