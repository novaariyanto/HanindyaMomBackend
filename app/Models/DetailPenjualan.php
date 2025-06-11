<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 'detail_penjualan';

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id');
    }
    
}
