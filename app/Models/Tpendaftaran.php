<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tpendaftaran extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 't_pendaftaran';
    protected $guarded = ["IDXDAFTAR"];


}
