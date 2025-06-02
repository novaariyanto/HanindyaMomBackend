<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndeksJasaTidakLangsung extends Model
{
    protected $table = 'indeks_jasa_tidak_langsung';
    protected $fillable = ['nama_indeks', 'nilai', 'kategori'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_indeks_jtl');
    }
   // Relationship dengan KategoriIndeksJasaTidakLangsung
   public function kategori()
   {
       return $this->belongsTo(KategoriIndeksJasaTidakLangsung::class, 'kategori_id');
   }

 

   public function pegawaiJasaTidakLangsung()
   {
       return $this->hasMany(PegawaiJasaTidakLangsung::class, 'jasa_id');
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
} 