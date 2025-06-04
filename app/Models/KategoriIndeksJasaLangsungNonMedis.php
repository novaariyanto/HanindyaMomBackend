<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriIndeksJasaLangsungNonMedis extends Model
{
    use SoftDeletes;
    
    protected $table = 'kategori_indeks_jasa_langsung_non_medis';
    
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'bobot',
        'status'
    ];
    
    protected $casts = [
        'bobot' => 'decimal:2',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    
    // Relationship dengan IndeksJasaLangsungNonMedis
    public function indeksJasa()
    {
        return $this->hasMany(IndeksJasaLangsungNonMedis::class, 'kategori_id');
    }
    
    // Scope untuk status aktif
    public function scopeAktif($query)
    {
        return $query->where('status', true);
    }
    
    // Accessor untuk nama kategori dengan format title case
    public function getNamaKategoriFormattedAttribute()
    {
        return ucwords(strtolower($this->nama_kategori));
    }
    
    // Accessor untuk format bobot
    public function getBobotFormattedAttribute()
    {
        return number_format($this->bobot, 2);
    }
}
