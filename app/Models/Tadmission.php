<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class Tadmission extends Model
{
    //
    protected $connection = 'simrs';
    protected $table = 't_admission';
    protected $guarded = ["id_admission"];

    public function pasien()
    {
        return $this->hasOne(Mpasien::class, 'NOMR', 'nomr');
    }
    // Relasi hasMany yang valid
    public function billranap()
    {
        return $this->hasMany(Tbillranap::class, 'IDXDAFTAR', 'id_admission');
            
    }
    public function billrajal()
    {
        return $this->hasMany(Tbillrajal::class, 'IDXDAFTAR', 'id_admission');
    }

    // Tambahkan accessor untuk total dengan query baru
    public function getTotalTarifRsAttribute()
    {
        // Inisialisasi total
        $totalRuang = 0;
        $totalLab = 0; 
        $totalRadiologi = 0;
        $totalKamarOperasi = 0;
        $totalFarmasi = 0;
        $totalRajal = 0;

        // Query untuk rawat inap
        $billRanap = DB::connection('simrs')
            ->table('t_billranap as b')
            ->join('m_tarif2012 as a', 'a.kode_tindakan', '=', 'b.KODETARIF')
            ->join('m_carabayar as c', 'c.KODE', '=', 'b.CARABAYAR')
            ->join('m_dokter as d', 'd.KDDOKTER', '=', 'b.KDDOKTER')
            ->where('b.IDXDAFTAR', $this->id_admission)
            ->where('b.NOMR', $this->nomr)
            ->where('b.status', '<>', 'BATAL')
            ->select('b.unit', 'b.QTY', 'b.TARIFRS', 'a.kode_unit')
            ->get();

        foreach($billRanap as $bill) {
            $subtotal = $bill->QTY * $bill->TARIFRS;
            
            if($bill->unit == '16') {
                $totalLab += $subtotal;
            } elseif($bill->unit == '17') {
                $totalRadiologi += $subtotal;
            } elseif($bill->unit == '14') {
                $totalFarmasi += $subtotal;
            } elseif($bill->kode_unit == '15') {
                $totalKamarOperasi += $subtotal;
            } else {
                $totalRuang += $subtotal;
            }
        }

        // Query untuk rawat jalan
        $billRajal = DB::connection('simrs')
            ->table('t_billrajal as b')
            ->join('m_tarif2012 as a', 'a.kode_tindakan', '=', 'b.KODETARIF')
            ->leftJoin('m_dokter as c', 'c.KDDOKTER', '=', 'b.KDDOKTER')
            ->where('b.IDXDAFTAR', $this->id_admission)
            ->where('b.NOMR', $this->nomr)
            ->select('b.QTY', 'b.TARIFRS')
            ->get();

        foreach($billRajal as $bill) {
            $totalRajal += $bill->QTY * $bill->TARIFRS;
        }

        // Total keseluruhan
        return $totalRuang + $totalLab + $totalRadiologi + $totalKamarOperasi + $totalFarmasi + $totalRajal;
    }
}