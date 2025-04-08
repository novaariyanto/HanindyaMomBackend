<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class PegawaiShift extends Model
{
    //
    protected $fillable = ['pegawai_id', 'shift_id', 'tanggal', 'created_by', 'updated_by'];

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

    public function shift(){
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

}
