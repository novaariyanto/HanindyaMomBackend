<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndexKategori extends Model
{
    use SoftDeletes;
    protected $table = 'index_kategori';
    protected $guarded = ['id'];
}
