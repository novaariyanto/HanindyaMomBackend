<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // Relasi ke Menu
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'role_menus');
    }
}