<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembagianKlaim extends Model
{
    use HasFactory;

    protected $table = 'pembagian_klaim';
    protected $guarded = ['id'];

    protected $fillable = [
        'groups',
        'jenis',
        'grade',
        'ppa',
        'value',
        'sumber',
        'flag',
        'del',
        'sep',
        'id_detail_source',
        'cluster',
        'idxdaftar',
        'nomr',
        'tanggal',
        'nama_ppa',
        'kode_dokter',
        'sumber_value',
        'nilai_remunerasi'
    ];

    protected $casts = [
        'value' => 'decimal:4',
        'del' => 'boolean',
        'cluster' => 'integer',
        'idxdaftar' => 'integer',
        'nomr' => 'integer',
        'tanggal' => 'date',
        'nama_ppa' => 'string',
        'kode_dokter' => 'integer',
        'sumber_value' => 'decimal:4',
        'nilai_remunerasi' => 'decimal:4'
    ];

    public function detailSource()
    {
        return $this->belongsTo(DetailSource::class, 'id_detail_source', 'id');
    }
} 