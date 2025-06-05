<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sepbpjs extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 'sep_bpjs';
    protected $guarded = ["id"];

    public function pendaftaran()
    {
        return $this->hasOne(Tpendaftaran::class, 'idxdaftar', 'IDXDAFTAR');
    }


}
