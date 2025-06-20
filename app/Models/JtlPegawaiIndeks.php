<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JtlPegawaiIndeks extends Model
{
    protected $table = 'jtl_pegawai_indeks';
    
    protected $fillable = [
        'dasar',
        'kompetensi',
        'resiko',
        'emergensi',
        'posisi',
        'kinerja',
        'jumlah',
        'rekening',
        'pajak',
        'unit_kerja_id',
        'unit_kerja',
        'nama_pegawai',
        'nik'
    ];

    protected $casts = [
        'dasar' => 'decimal:2',
        'kompetensi' => 'decimal:2',
        'resiko' => 'decimal:2',
        'emergensi' => 'decimal:2',
        'posisi' => 'decimal:2',
        'kinerja' => 'decimal:2',
        'jumlah' => 'decimal:2'
    ];

    // Relasi ke tabel Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id');
    }
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    // Method untuk menghitung total jumlah otomatis
    public function calculateJumlah()
    {
        $this->jumlah = $this->dasar + $this->kompetensi + $this->resiko + 
                       $this->emergensi + $this->posisi + $this->kinerja;
        return $this->jumlah;
    }

    // Boot method untuk auto calculate jumlah sebelum save
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculateJumlah();
        });
    }
} 