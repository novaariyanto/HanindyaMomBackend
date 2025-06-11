<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 'penjualan';

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan', 'id');
    }
    
}
