<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndeksJasaLangsungNonMedis extends Model
{
    use SoftDeletes;
    
    protected $table = 'indeks_jasa_langsung_non_medis';
    
    protected $fillable = [
        'nama_indeks', 
        'nilai', 
        'kategori_id',
        'status',
        'bobot'
    ];
    
    protected $casts = [
        'nilai' => 'decimal:2',
        'bobot' => 'decimal:2',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationship dengan KategoriIndeksJasaLangsungNonMedis
    public function kategori()
    {
        return $this->belongsTo(KategoriIndeksJasaLangsungNonMedis::class, 'kategori_id');
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_indeks_jl_non_medis');
    }

    public function pegawaiJasaNonMedis()
    {
        return $this->hasMany(PegawaiJasaNonMedis::class, 'jasa_id');
    }
    
    // Scope untuk status aktif
    public function scopeAktif($query)
    {
        return $query->where('status', true);
    }
    
    // Accessor untuk nama indeks dengan format title case
    public function getNamaIndeksFormattedAttribute()
    {
        return ucwords(strtolower($this->nama_indeks));
    }
    
    // Accessor untuk nilai terformat
    public function getNilaiFormattedAttribute()
    {
        return number_format($this->nilai, 2, ',', '.');
    }

    // Accessor untuk bobot terformat
    public function getBobotFormattedAttribute()
    {
        return number_format($this->bobot, 2, ',', '.');
    }
} 