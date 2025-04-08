<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    //
    protected $connection = 'eprofile';
    protected $table = 'pegawai';
    protected $fillable = [
        'nama', 'nip', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama_id',
        'alamat', 'province_id', 'regency_id', 'district_id', 'village_id', 'jenis_pegawai',
        'profesi_id', 'email', 'nohp', 'is_deleted'
    ];


    public function profesi()
    {
        return $this->belongsTo(Profesi::class, 'profesi_id', 'id');
    }


    
    public function mutasi()
    {
        return $this->hasMany(PegawaiMutasi::class, 'pegawai_id');
    }

   
     // Relasi: Seorang pegawai dapat memiliki satu unit kerja saat ini (mutasi terakhir)
     public function mutasiAktif()
     {
         return $this->hasOne(PegawaiMutasi::class, 'pegawai_id', 'id')
                     ->where('status', '1') // Status aktif
                     ->orderByDesc('tahun_masuk'); // Ambil yang paling baru
     }

}
