<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class DivisiShift extends Model
{
    //
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
    
    
}
