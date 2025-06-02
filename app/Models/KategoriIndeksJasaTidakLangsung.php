<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriIndeksJasaTidakLangsung extends Model
{
    use SoftDeletes;
    
    protected $table = 'kategori_indeks_jasa_tidak_langsung';
    
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'status'
    ];
    
    protected $casts = [
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
}
