<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mtarif extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 'm_tarif2012';
    protected $guarded = ["kode_tindakan"];

 

}
