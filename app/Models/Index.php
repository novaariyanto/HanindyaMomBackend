<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Index extends Model
{
    use SoftDeletes;

    // Nama tabel yang digunakan
    protected $table = 'index_grade';

    // Kolom yang dapat diisi secara massal (fillable)
    protected $fillable = [
        'nama',
        'index',
        'index_kategori_id',
    ];

    // Kolom tanggal yang perlu di-cast sebagai instance Carbon
    protected $dates = ['deleted_at'];

    // Relasi ke tabel index_kategori
    public function kategori()
    {
        return $this->belongsTo(IndexKategori::class, 'index_kategori_id');
    }
}
