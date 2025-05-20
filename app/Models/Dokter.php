<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 'm_dokter';
    protected $guarded = ["KDDOKTER"];


}
