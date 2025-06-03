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
        'unit_kerja_id',
        'jenis_pegawai',
        'profesi_id',
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
    
    // Relasi ke model Profesi
    public function profesi()
    {
        return $this->belongsTo(Profesi::class, 'profesi_id', 'id');
    }
    
    // Relasi ke model UnitKerja
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }
    
    // Accessor untuk jenis pegawai
    public function getJenisPegawaiLabelAttribute()
    {
        $jenis = [
            'PNS' => 'Pegawai Negeri Sipil',
            'PPPK' => 'Pegawai Pemerintah dengan Perjanjian Kerja',
            'KONTRAK' => 'Pegawai Kontrak',
            'HONORER' => 'Tenaga Honorer'
        ];
        
        return $jenis[$this->jenis_pegawai] ?? $this->jenis_pegawai;
    }
}
