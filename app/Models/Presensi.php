<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Presensi extends Model
{
    //
     // Kolom yang dapat diisi secara massal
     protected $fillable = [
        'uuid',
        'pegawai_id',
        'pegawai_shift_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'jam_masuk_jadwal',
        'jam_keluar_jadwal',
        'status',
        'keterangan',
        'created_by',
        'updated_by',
        'longitude_masuk',
        'latitude_masuk',
        'longitude_keluar',
        'latitude_keluar',
        'face_landmarks_in',
        'face_landmarks_out',
        'terlambat_detik',
        'durasi_kerja_detik',
        'pulang_cepat_detik',
        'catatan',
        'divisi_id'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    
    public function getRouteKeyName()
    {
        return 'uuid'; // Menggunakan UUID untuk route model binding
    }



  
      // Relasi ke model PegawaiMaster
      public function divisi()
      {
          return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
      }

    // Relasi ke model PegawaiMaster
    public function pegawai()
    {
        return $this->belongsTo(PegawaiMaster::class, 'pegawai_id', 'id');
    }

    // Relasi ke model PegawaiShift
    public function pegawaiShift()
    {
        return $this->belongsTo(PegawaiShift::class, 'pegawai_shift_id', 'id');
    }

    // Relasi ke model User untuk created_by
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Relasi ke model User untuk updated_by
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    
}
