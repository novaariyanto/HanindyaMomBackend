<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JtlPegawaiHasil extends Model
{
    protected $table = 'jtl_pegawai_hasil';
  
    protected $fillable = [
        'id_pegawai',
        'remunerasi_source',
        'nik',
        'nama_pegawai',
        'unit_kerja_id',
        'unit_kerja',
        'dasar',
        'kompetensi',
        'resiko',
        'emergensi',
        'posisi',
        'kinerja',
        'jumlah',
        'nilai_indeks',
        'jtl_bruto',
        'pajak',
        'potongan_pajak',
        'jtl_net',
        'rekening'
    ];

    protected $casts = [
        'dasar' => 'decimal:2',
        'kompetensi' => 'decimal:2',
        'resiko' => 'decimal:2',
        'emergensi' => 'decimal:2',
        'posisi' => 'decimal:2',
        'kinerja' => 'decimal:2',
        'jumlah' => 'decimal:2',
        'nilai_indeks' => 'decimal:2',
        'jtl_bruto' => 'decimal:2',
        'pajak' => 'decimal:2',
        'potongan_pajak' => 'decimal:2',
        'jtl_net' => 'decimal:2'
    ];

    // Relasi ke tabel RemunerasiSource
    public function remunerasiSource()
    {
        return $this->hasOne(RemunerasiSource::class, 'id', 'remunerasi_source');
    }

    // Relasi ke tabel Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id');
    }

    // Relasi ke tabel UnitKerja
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    // Method untuk menghitung JTL Bruto
    public function calculateJtlBruto()
    {
        $this->jtl_bruto = $this->jumlah * $this->nilai_indeks;
        return $this->jtl_bruto;
    }

    // Method untuk menghitung potongan pajak
    public function calculatePotonganPajak()
    {
        if ($this->pajak > 0) {
            $this->potongan_pajak = ($this->pajak / 100) * $this->jtl_bruto;
        } else {
            $this->potongan_pajak = 0;
        }
        return $this->potongan_pajak;
    }

    // Method untuk menghitung JTL Net
    public function calculateJtlNet()
    {
        $this->jtl_net = $this->jtl_bruto - $this->potongan_pajak;
        return $this->jtl_net;
    }

    // Method untuk menghitung semua nilai sekaligus
    public function calculateAll()
    {
        $this->calculateJtlBruto();
        $this->calculatePotonganPajak();
        $this->calculateJtlNet();
        return $this;
    }

    // Boot method untuk auto calculate sebelum save
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculateAll();
        });
    }
}
