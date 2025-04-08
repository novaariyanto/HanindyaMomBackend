<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Menu extends Model
{
    protected $fillable = [
        'uuid', 'route', 'icon', 'nama_menu', 'parent_id','order'
    ];

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
    

    // Relasi untuk submenu
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    // Relasi untuk parent menu
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Scope untuk mendapatkan menu utama (tanpa parent)
    public function scopeMainMenus($query)
    {
        return $query->whereNull('parent_id');
    }


    // Relasi ke Role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_menus');
    }


}
