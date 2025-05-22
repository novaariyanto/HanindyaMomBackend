<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class PegawaiMaster extends Model
{
    //
    protected $fillable = ['nama', 'nip', 'jabatan_id', 'divisi_id', 'status','id_user'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
            $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid'; // Menggunakan UUID untuk route model binding
    }
    public function absensi()
{
    return $this->hasMany(Presensi::class,'pegawai_id');
}


    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik', 'nik');
    }
    
    public function jabatan()
{
    return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
}
public function divisi()
{
    return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
}

public function pegawaiShifts()
{
    return $this->hasMany(PegawaiShift::class, 'pegawai_id', 'id');
}
 
// File: PegawaiMaster.php
public function user()
{
    return $this->belongsTo(User::class, 'id_user'); // Asumsi foreign key adalah 'user_id'
}


// File: PegawaiMaster.php
public function presensi()
{
    return $this->hasMany(Presensi::class, 'pegawai_id');
}


}
