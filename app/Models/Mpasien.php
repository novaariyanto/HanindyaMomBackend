<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mpasien extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 'm_pasien';
    protected $guarded = ["NOMR"];



}
