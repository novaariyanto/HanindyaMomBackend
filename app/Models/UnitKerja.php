<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    //
    protected $connection = 'eprofile';
    protected $table = 'unit_kerja';
    protected $fillable = ['nama'];

    public function pegawaiMutasi()
    {
        return $this->hasMany(PegawaiMutasi::class, 'unit_kerja_id');
    }
    
      // Relasi: Satu unit kerja dapat memiliki banyak mutasi pegawai
      public function mutasi()
      {
          return $this->hasMany(PegawaiMutasi::class, 'unit_kerja_id', 'id');
      }
  
      // Relasi: Satu unit kerja dapat memiliki banyak pegawai aktif
      public function pegawaiAktif()
      {
          return $this->hasManyThrough(
              Pegawai::class,
              PegawaiMutasi::class,
              'unit_kerja_id', // Foreign key di tabel pegawai_mutasi
              'id',            // Foreign key di tabel pegawai
              'id',            // Local key di tabel unit_kerja
              'pegawai_id'     // Local key di tabel pegawai_mutasi
          )->where('status', '1'); // Hanya pegawai dengan status aktif
      }
      
}
