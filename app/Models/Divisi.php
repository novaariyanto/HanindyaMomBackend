<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Divisi extends Model
{
    //


    protected $fillable = [
        'uuid',
        'nama',
        'keterangan',
    ];

    // Relasi: Satu divisi memiliki banyak shift (melalui tabel pivot)
    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'divisi_shifts', 'divisi_id', 'shift_id')
                    ->withTimestamps()
                    ->withPivot('uuid'); // Menambahkan kolom uuid dari tabel pivot

    }

    
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

    public function pegawaiMasters()
{
    return $this->hasMany(PegawaiMaster::class, 'divisi_id', 'id');
}


 // Relasi many-to-many dengan User
 public function users()
 {
     return $this->belongsToMany(User::class, 'user_divisi', 'divisi_id', 'user_id');
 }
 

 
    
}
