<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndeksPegawai extends Model
{
    use SoftDeletes;
    
    protected $table = 'indeks_pegawai';
    
    protected $fillable = [
        'nama',
        'nip',
        'nik',
        'unit',
        'cluster_1',
        'cluster_2',
        'cluster_3',
        'cluster_4',
        'is_deleted'
    ];

    protected $casts = [
        'is_deleted' => 'boolean'
    ];
    
    protected $dates = ['deleted_at'];
}
