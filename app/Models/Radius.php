<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radius extends Model
{
    //
    use HasFactory;

    protected $fillable = ['coordinates', 'width', 'height'];
    protected $table = 'radius';
}
