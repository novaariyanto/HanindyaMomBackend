<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Shift extends Model
{
    protected $fillable = [
        'id', 'nama','kode_shift'
    ];
    //
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

    public function jamKerja()
    {
        return $this->hasMany(JamKerja::class, 'shift_id');
    }

        // Relasi: Satu shift dimiliki oleh banyak divisi (melalui tabel pivot)
        public function divisis()
        {
            return $this->belongsToMany(Divisi::class, 'divisi_shifts', 'shift_id', 'divisi_id')
                        ->withTimestamps(); // Menambahkan timestamps jika ada kolom created_at dan updated_at di tabel pivot
        }
        

    
    
}
