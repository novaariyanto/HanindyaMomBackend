<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jtldata extends Model
{
    protected $table = 'jtl_data';
  
    protected $fillable = [
        'id_remunerasi_source',
        'jumlah_jtl',
        'jumlah_indeks', 
        'nilai_indeks',
        'allpegawai'
    ];

    protected $casts = [
        'jumlah_jtl' => 'decimal:2',
        'jumlah_indeks' => 'decimal:2',
        'nilai_indeks' => 'decimal:2',
        'allpegawai' => 'integer'
    ];

    public function remunerasiSource()
    {
        return $this->belongsTo(RemunerasiSource::class, 'id_remunerasi_source', 'id');
    }

}