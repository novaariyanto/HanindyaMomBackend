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
        // Menghitung total per unit
        $totalRuang = DB::connection('simrs')
            ->table('t_billranap as f')
            ->where('f.IDXDAFTAR', $this->id_admission)
            ->where('f.UNIT', 19)
            ->where('f.status', '<>', 'BATAL')
            ->where('f.status_tindakan', '=', 1)
            ->sum(DB::raw('f.QTY * f.TARIFRS'));

        $totalLab = DB::connection('simrs')
            ->table('t_billranap as f')
            ->where('f.IDXDAFTAR', $this->id_admission)
            ->where('f.UNIT', 16)
            ->where('f.status', '<>', 'BATAL')
            ->where('f.status_tindakan', '=', 1)
            ->sum(DB::raw('f.QTY * f.TARIFRS'));

        $totalRadiologi = DB::connection('simrs')
            ->table('t_billranap as f')
            ->where('f.IDXDAFTAR', $this->id_admission)
            ->where('f.UNIT', 17)
            ->where('f.status', '<>', 'BATAL')
            ->where('f.status_tindakan', '=', 1)
            ->sum(DB::raw('f.QTY * f.TARIFRS'));

        $totalKamarOperasi = DB::connection('simrs')
            ->table('t_billranap as f')
            ->where('f.IDXDAFTAR', $this->id_admission)
            ->where('f.UNIT', 15)
            ->where('f.status', '<>', 'BATAL')
            ->where('f.status_tindakan', '=', 1)
            ->sum(DB::raw('f.QTY * f.TARIFRS'));

        $totalFarmasi = DB::connection('simrs')
            ->table('t_billranap as f')
            ->where('f.IDXDAFTAR', $this->id_admission)
            ->where('f.UNIT', 14)
            ->where('f.status', '<>', 'BATAL')
            ->where('f.status_tindakan', '=', 1)
            ->sum(DB::raw('f.QTY * f.TARIFRS'));

        // Menghitung total keseluruhan
        return $totalRuang + $totalLab + $totalRadiologi + $totalKamarOperasi + $totalFarmasi;
    }
}