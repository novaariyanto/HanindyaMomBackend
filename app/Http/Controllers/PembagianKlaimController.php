<?php

namespace App\Http\Controllers;

use App\Models\PembagianKlaim;
use App\Models\Tbpjs;
use App\Models\Dokter;
use App\Models\DetailSource;
use App\Models\ProporsiFairness;
use App\Models\Tbillrajal;
use App\Models\Tbillranap;
use App\Models\Tpendaftaran;
use App\Models\Tadmission;
use App\Models\Moperasi;
use App\Models\Tradiologi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use App\Models\Divisi;
use App\Models\RemunerasiSource;

class PembagianKlaimController extends Controller
{
    /**
     * Menampilkan daftar pembagian klaim.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PembagianKlaim::where('del', false);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('pembagian-klaim.show', $row->id) . '" class="btn btn-info btn-sm btn-edit" title="Edit">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <a href="#" data-url="' . route('pembagian-klaim.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                            <i class="ti ti-trash"></i>
                        </a>
                    ';
                })
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('value', function($row) {
                    return number_format($row->value, 4, ',', '.');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pembagian-klaim.index');
    }
   
    function hitung($sourceId,DetailSource $detailSource) {
      
       
        $failed = 0;
        $success = 0;
        $message = [];
        $data_detail_source = $detailSource;
        // foreach($detail_source as $row){
            // $data_detail_source = $row;
        if($data_detail_source->jenis == 'Rawat Jalan'){
            if(strpos($data_detail_source->no_sep,"-")){
                    //membaca idxdaftar dan nomr / pasien umum
                    $idxdaftar = $data_detail_source->idxdaftar;
                    $data_pendaftaran = Tpendaftaran::where('IDXDAFTAR',$idxdaftar)->first();
                    $totalTarifRs = $data_pendaftaran->getTotalTarifRsAttribute();
                    $data_pendaftaran->total_tarif_rs = $totalTarifRs;
                    $idxdaftar = $data_pendaftaran->IDXDAFTAR;
                    $nomr = $data_pendaftaran->NOMR;
                   
    
                    $selisih = $totalTarifRs-$totalTarifRs;
                    if($selisih > 0){
                        $persentase_selisih = $selisih/$totalTarifRs;
                        $persentase_selisih = $persentase_selisih*100;
                        $persentase_selisih = round($persentase_selisih, 2);
                    }else{
                        if($data_pendaftaran->KDPOLY == 201){
                            $persentase_selisih = 0;
                        }else{
                            $persentase_selisih = 10;
                        }
                    }
                    
                
            
                    $grade = Grade::where('persentase', '>=', $persentase_selisih)
                        ->orderBy('persentase', 'ASC')
                        ->first();
                        
                    $grade = $grade->grade;
                    $VERIFIKASITOTAL = $totalTarifRs;
            }else{
                // bpjps
                $sep = $data_detail_source->no_sep;
                $data = $this->getIdxDaftar($sep);
                $idxdaftar = $data['idxdaftar'];
                $nomr = $data['nomr'];
                  
                $selisih = $data_detail_source->biaya_disetujui-$data_detail_source->biaya_riil_rs;
                $selisih = $selisih*-1;
                if ($data_detail_source->biaya_disetujui != 0) {
                    $persentase_selisih = ($selisih / $data_detail_source->biaya_disetujui) * 100;
                } else {
                    $persentase_selisih = 0; // Atau null, tergantung logika kamu
                }
                $persentase_selisih = $persentase_selisih*100;
                if($persentase_selisih < 0){
                    $persentase_selisih = 0;
                }else if($persentase_selisih >= 20){
                    $persentase_selisih = 20;
                }else{
                    $persentase_selisih = $persentase_selisih;
                }        
                $grade = Grade::where('persentase', '>=', $persentase_selisih)
                    ->orderBy('persentase', 'ASC')
                    ->first();   
    
            
                    $grade = $grade->grade;
                    $sep = $data_detail_source->no_sep;
    
                 $VERIFIKASITOTAL = $data_detail_source->biaya_disetujui;
            }
        
    
            $tpendaftaran = Tpendaftaran::where('IDXDAFTAR', $idxdaftar)->first();
            $databilling = Tbillrajal::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();
           
            
           
            $pisau = 0; //v
            $TOTALLPA = 0;//v
            $TOTALPATKLIN = 0;//v
            $TOTALRADIOLOGI = 0;//v
            $TOTALBDRS = 0;//
            $TOTALHD = 0;
            $TINDAKANRAJAL_HARGA = 0;//
            $TOTALBANKDARAH = 0;
            $EMBALACE = 0;
            $Dokter_Umum_IGD = 0;
            
            $DPJP = @$tpendaftaran->KDDOKTER;
            // ------------	
            $DOKTERKONSUL = "";
            $KONSULEN = "";
            $DPJPRABER = "";
            $DOKTERRABER = "";
            // ------------
            $LABORATORIST = "";
            $RADIOLOGIST = "";
            $AHLIGIZI = "";
            $ANALISLABKLINIK = "";
            $RADIOGRAFER = "";

            $PERAWAT = 127;
            // ------------
            $DOKTERBDRS= "";
            $TIMBDRS = "";
    
            $ANESTESI = "";
            $PENATA = "";
            $ASISTEN = "";
    
            $CATHLAB = "";
            $DOKTERLPA = "";
            $TIMLPA = "";
            $ESWL = "";
            $HD = "";
            
            $TINDAKANRAJAL = "";
            $DOKTERHDRAJAL = "";
            $PERAWATHDRAJAL = "";
            $DPJPCATHLAB = "";
            $Apoteker = "";
            $STRUKTURAL = 1;
            $JTL = 1;
            $PENATABANKDARAH = "";
            
            
            foreach($databilling as $row){
                
                if(in_array($row->id_kategori, [3,41,30,4,5,6,28,22,23,24,25,26,27,29,30])){
                 
                    $TINDAKANRAJAL_HARGA += $row->TARIFRS;
                    $TINDAKANRAJAL = $row->KDDOKTER;
                   
                }
               
                if($row->UNIT == 15){
                    $pisau += 1;
                    $data_operasi = Moperasi::where(['IDXDAFTAR' => $idxdaftar, 'nomr' => $nomr])->where('status', '!=', 'batal')->get();
                    foreach($data_operasi as $row_operasi){
                        $OPERATOR[] = $row_operasi->kode_dokteroperator;
                        if($row_operasi->kode_dokteranastesi != ""){
                            $ANESTESI = $row_operasi->kode_dokteranastesi;
                            $PENATA = "9";
                        }
                        
                    }
                    $ASISTEN = "10";
                   
                  
                }
                if(in_array($row->id_kategori, [14])){
                        
                    if($row->UNIT == '16'){
                        $TOTALPATKLIN += $row->TARIFRS;
                        $LABORATORIST = $row->KDDOKTER;
                        $ANALISLABKLINIK = "17";
                    }else if($row->UNIT == '163'){
                        $TOTALLPA += $row->TARIFRS;
                        $DOKTERLPA = 884;
                        $ANALISLABKLINIK = "18";
                    }
                    
                    
                }
                if(in_array($row->id_kategori, [15])){
                        
                    $TOTALBANKDARAH += $row->TARIFRS;
                    $PENATABANKDARAH = 19;
                     
                 }
            
                if($row->UNIT == 17){
                    // cari dokter radiologi
                     $TOTALRADIOLOGI += $row->TARIFRS;
                    // $RADIOLOGIST = $row->KDDOKTER;
                    // cari dokterariologi
                    $radiologi = Tradiologi::where('IDXDAFTAR', $idxdaftar)->where('NOMR', $nomr)->first();
                    if($radiologi){
                        $RADIOLOGIST = $radiologi->DRRADIOLOGI;
                    }else{
                        $RADIOLOGIST = $row->KDDOKTER;
                    } 
                    

                    $RADIOGRAFER = "16";
                }
                if(in_array($row->id_kategori, [21])){
                    $HD  = $row->KDDOKTER;
                    // $DOKTERHDRANAP = $row->KDDOKTER;
                    $TOTALHD += $row->TARIFRS;
                    $PERAWATHDRAJAL = 8;
                }
                
                if(in_array($row->KODETARIF, ['07'])){
                    $Apoteker = 6;
                    $EMBALACE += 1;
                }
    
            }
            
            if(in_array(@$tpendaftaran->KDPOLY,[31,168,169])){
                $TINDAKANRAJAL = $tpendaftaran->KDDOKTER;
                $DPJP = "813" ;
                
            }else if(in_array(@$tpendaftaran->KDPOLY,[101])){
                $TINDAKANRAJAL = "832";
                $DPJP = "832";
            }
            
            $data_sumber = [
                "HARGA" => $TINDAKANRAJAL_HARGA,
                "EMBALACE" => $EMBALACE,
                "TOTALPATKLIN" => $TOTALPATKLIN,
                "TOTALLPA" => $TOTALLPA,
                "TOTALRADIOLOGI" => $TOTALRADIOLOGI,
                "TOTALBDRS" => $TOTALBDRS,
                "VERIFIKASITOTAL" => $VERIFIKASITOTAL,
                "TOTALBANKDARAH" => $TOTALBANKDARAH
            ];
         
            
            
    
            
            // cari data proporsi
            $proporsi_fairness = ProporsiFairness::
            where('grade', $grade)
            ->where('groups', ($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL")
            ->where('jenis', ($pisau)?"PISAU":"NONPISAU")
            ->get();
            
            $pembagian = [];
            $divisi = Divisi::pluck('nama', 'id');
            $total_remunerasi = 0;
    
            $proporsi_fairness_radiologi = [];
            $proporsi_fairness_laboratorist = [];

            foreach($proporsi_fairness as $row){
                
                if(@${$row['ppa']} != "" && @${$row['ppa']} != 0){
    
                        $divisi_id = $divisi->search(function ($item, $key) use ($row) {
                            return $item == $row->ppa;
                        });
    
    
                        if($divisi_id !== false){
                            $nama_dokter = $row->ppa;
                            $kode_dokter = $divisi_id;
                            if($row->ppa == "Dokter_Umum_IGD"){
                                $cluster = 1;
                            }else if($row->ppa == "STRUKTURAL"){
                                $cluster = 3;
                            }else if($row->ppa == "TERAPIS"){
                                $cluster = 2;
                            }else if($row->ppa == "JTL"){
                                $cluster = 4;
                            }else{
                                $cluster = 2;
                            }
                        }else{
                            $dokter = Dokter::where('KDDOKTER', @${$row['ppa']})->first();
                            $nama_dokter = $dokter->NAMADOKTER;
                            $kode_dokter = @${$row['ppa']};
                            $cluster = 1;
                        }
                        
                        if($nama_dokter == ""){
                            $kode_dokter = 0;
                            $nilai_remunerasi = 0;
                        }
    
                        if($row['sumber'] == "HARGA"){
                            if($row['value'] > 1 ){
                                if(@$tpendaftaran->KDPOLY == 104){
                                    $nilai_remunerasi = 20000;
                                }else{
                                    $nilai_remunerasi = $row['value'];
                                }
                            }else{
                                $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                            }
                            
                        }else if($row['sumber'] == "EMBALACE"){
                            $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                        }
                        else{
                            $nilai_remunerasi = $data_sumber[$row['sumber']]*$row['value'];
                        }

                      
                        if($row['ppa'] == "Dokter_Umum_IGD"){
                            $proporsi_fairness_umum_igd = $row;
                        }
    
                        
                            
                        
                    }else{
                        $nilai_remunerasi = 0;
                        $nama_dokter = "";
                        $kode_dokter = 0;
    
                    }
    
                    
                    if($nilai_remunerasi > 0){    
                        $data = [
                            'groups'=>$row['groups'],
                            'jenis'=>$row['jenis'],
                            'grade'=>$grade,
                            'ppa'=>$row['ppa'],
                            'value'=>$row['value'],
                            'sumber'=>$row['sumber'],
                            'flag'=>$row['flag'],
                            'del'=>$row['del'],
                            'sep'=>$data_detail_source->no_sep,
                            'id_detail_source'=>$data_detail_source->id,
                            'cluster'=>$cluster,
                            'idxdaftar'=>$idxdaftar,
                            'nomr'=>$nomr,
                            'tanggal'=>$data_detail_source->tgl_verifikasi,
                            'nama_ppa'=>$nama_dokter,
                            'kode_dokter'=>@$kode_dokter,
                            'sumber_value'=>$data_sumber[$row['sumber']],
                            'nilai_remunerasi'=>$nilai_remunerasi,
                            'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                        ];     
                        $total_remunerasi += $nilai_remunerasi;          
                        $savePembagianKlaim = PembagianKlaim::create($data);
                    }
            } 

            if( $TOTALBANKDARAH > 0){
                $dokter_bankdarah = [705,133];
                $persentase_bankdarah = [0.03,0.02];
                foreach($dokter_bankdarah as $key => $dokter){
                    $nama_dokter = Dokter::where('KDDOKTER', $dokter)->first()->NAMADOKTER;
                    $data = [
                        'groups'=>($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL",
                        'jenis'=>$data_detail_source->jenis,
                        'grade'=>$grade,
                        'ppa'=>"Dokter_Bank_Darah",
                        'value'=>$persentase_bankdarah[$key],
                        'sumber'=>'TOTALBANKDARAH',
                        'flag'=>'',
                        'del'=>0,
                        'sep'=>$data_detail_source->no_sep,
                        'id_detail_source'=>$data_detail_source->id,
                        'cluster'=>1,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr,
                        'tanggal'=>$data_detail_source->tgl_verifikasi,
                        'nama_ppa'=>$nama_dokter,
                        'kode_dokter'=>@$dokter,
                        'sumber_value'=>($data_sumber['TOTALBANKDARAH']),
                        'nilai_remunerasi'=>$persentase_bankdarah[$key]*$data_sumber['TOTALBANKDARAH'],
                        'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                    ];   
                    $total_remunerasi += $persentase_bankdarah[$key]*$data_sumber['TOTALBANKDARAH'];  
                    $savePembagianKlaim = PembagianKlaim::create($data);
                }
                
            }
           
           

            if($savePembagianKlaim){
              
                if($data_detail_source->biaya_disetujui == 0){
                    
                    $update = DetailSource::where('id', $detailSource->id)
                    ->update([
                            'status_pembagian_klaim'=>1,
                            'idxdaftar'=>$idxdaftar,
                            'biaya_disetujui'=>$VERIFIKASITOTAL,
                            'biaya_riil_rs'=>$VERIFIKASITOTAL,
                            'biaya_diajukan'=>$VERIFIKASITOTAL,
                            'total_remunerasi'=>$total_remunerasi,
                            'nomr'=>$nomr
                        ]);
                }else{
                    $update = DetailSource::where('id', $detailSource->id)
                    ->update([
                            'status_pembagian_klaim'=>1,
                            'idxdaftar'=>$idxdaftar,
                            'total_remunerasi'=>$total_remunerasi,
                            'nomr'=>$nomr
                        ]);
                }
                $failed += 0;
                $success += 1;
                    $message[] = "data $detailSource->no_sep berhasil di proses";
            }else{
                $update = DetailSource::where('id', $detailSource->id)
                ->update([
                    'status_pembagian_klaim'=>2
                ]);
                $failed += 1;
                $success += 0;
                $message[] = "data $detailSource->no_sep gagal di proses";
            }      
        }else if($data_detail_source->jenis == 'Rawat Inap'){
            // bpjps
            if(strpos($data_detail_source->no_sep,"-")){
                //membaca idxdaftar dan nomr / pasien umum
                $idxdaftar = $data_detail_source->idxdaftar;
                $data_admission = Tadmission::where('id_admission',$idxdaftar)->first();
                $totalTarifRs = $data_admission->getTotalTarifRsAttribute();
                $data_admission->total_tarif_rs = $totalTarifRs;
                $idxdaftar = $data_admission->id_admission;
                $nomr = $data_admission->nomr;
    
    
                $selisih = $totalTarifRs-$totalTarifRs;
                $persentase_selisih = $selisih/$totalTarifRs;
                $persentase_selisih = $persentase_selisih*100;
                
                $persentase_selisih = round($persentase_selisih, 2);
            
    
                $grade = Grade::where('persentase', '>=', $persentase_selisih)
                    ->orderBy('persentase', 'ASC')
                    ->first();
                    
                $grade = $grade->grade;
                
                $VERIFIKASITOTAL = $totalTarifRs;
    
            }else{
                // bpjps
                 $sep = $data_detail_source->no_sep;
                $data = $this->getIdxDaftar($sep);
                $idxdaftar = $data['idxdaftar'];
                $nomr = $data['nomr'];
                
                $selisih = $data_detail_source->biaya_disetujui-$data_detail_source->biaya_riil_rs;
                $selisih = $selisih*-1;
                if ($data_detail_source->biaya_disetujui != 0) {
                    $persentase_selisih = ($selisih / $data_detail_source->biaya_disetujui) * 100;
                } else {
                    $persentase_selisih = 0; // Atau null, tergantung logika kamu
                }
                $persentase_selisih = $persentase_selisih*100;
                if($persentase_selisih < 0){
                    $persentase_selisih = 0;
                }else if($persentase_selisih >= 20){
                    $persentase_selisih = 20;
                }else{
                    $persentase_selisih = $persentase_selisih;
                }        
                $grade = Grade::where('persentase', '>=', $persentase_selisih)
                    ->orderBy('persentase', 'ASC')
                    ->first();   
    
    
                    $grade = $grade->grade;
                    $sep = $data_detail_source->no_sep;
    
                $VERIFIKASITOTAL = $data_detail_source->biaya_disetujui;
            }
          
            $tadmission = Tadmission::where('id_admission', $idxdaftar)->first();
            $databilling = Tbillranap::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();
            $databilling_rajal = Tbillrajal::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();
          
    
            
            $pisau = 0; //
            $TOTALLPA = 0;//
            $TOTALPATKLIN = 0;//
            $TOTALRADIOLOGI = 0;//
            $TOTALBDRS = 0;//
            $TOTALHD = 0;
            $TOTALBANKDARAH = 0;
            $TINDAKANRAJAL_HARGA = 0;//
            $EMBALACE = 0;
            $TAHLIGIZI = 0;
            $Dokter_Umum_IGD = 0;
            
            $DPJP = @$tadmission->dokter_penanggungjawab;
            // ------------	
            $DOKTERKONSUL = "";
            $KONSULEN = "";
            $DPJPRABER = "";
            $DOKTERRABER = "";
            // ------------
            $LABORATORIST = "";
            $RADIOLOGIST = "";
            $AHLIGIZI = "";
            $ANALISLABKLINIK = "";
            $RADIOGRAFER = "";

            $PERAWAT = 127;
            // ------------
            $DOKTERBDRS= "";
            $TIMBDRS = "";
            $ANESTESI = "";
            $PENATA = "";
            $ASISTEN = "";
            $CATHLAB = "";
            $DOKTERLPA = "";
            $TIMLPA = "";
            $ESWL = "";
            $HD = "";
            
            $TINDAKANRAJAL = "";
            $DOKTERHDRAJAL = "";
            $Perawat_HD_Rajal = "";
            $DPJPCATHLAB = "";
            $PERAWAT_HD = "";
            $Apoteker = "";
            $STRUKTURAL = 1;
            $JTL = 1;
            $AHLIGIZI= "";
    
    
            
            $kddokter = [];
            $kddokter[] = $DPJP;
            $dokters_umum = [];
            $PENATABANKDARAH = "";
            

            $billing= [];
            foreach($databilling as $row1){
                $billing[] = $row1;
            }
            foreach($databilling_rajal as $row2){
                $billing[] = $row2;
            }
           

            foreach($billing as $row){
                
               
                if($row->UNIT == 15){
                    $pisau += 1;
                    $data_operasi = Moperasi::where(['IDXDAFTAR' => $idxdaftar, 'nomr' => $nomr])->where('status', '!=', 'batal')->get();
                    foreach($data_operasi as $row_operasi){
                        $OPERATOR[] = $row_operasi->kode_dokteroperator;
                        if($row_operasi->kode_dokteranastesi != ""){
                            $ANESTESI = $row_operasi->kode_dokteranastesi;
                              $PENATA = "9";
                        }
                        
                    }
    
                  
                    $ASISTEN = "10";
                }else if($row->UNIT == 17){
                    // cari dokter radiologi
                     $TOTALRADIOLOGI += $row->TARIFRS;
                    // $RADIOLOGIST = $row->KDDOKTER;
                    // cari dokterariologi
                    $radiologi = Tradiologi::where('IDXDAFTAR', $idxdaftar)->where('NOMR', $nomr)->first();
                    if($radiologi){
                        $RADIOLOGIST = $radiologi->DRRADIOLOGI;
                    }else{
                        $RADIOLOGIST = $row->KDDOKTER;
                    } 
                    

                    $RADIOGRAFER = "16";
                }
                if($row->id_kategori == 2||$row->id_kategori == 1){
                    if(!($row->KDDOKTER == $DPJP) && !in_array($row->KDDOKTER, [415,800,856,888])){
                        $kdprofesi = Dokter::where('KDDOKTER', $row->KDDOKTER)->first()->KDPROFESI;
                        if($kdprofesi == 1){
                            $kddokter[] = $row->KDDOKTER;
                        }else{
                            if (!in_array($row->KDDOKTER, $dokters_umum)) {
                                $dokters_umum[] = $row->KDDOKTER;
                            }
                        }
                    }
                }
                
                if(in_array($row->id_kategori, [14])){
                        
                    if($row->UNIT == '16'){
                        $TOTALPATKLIN += $row->TARIFRS;
                        $LABORATORIST = $row->KDDOKTER;
                        $ANALISLABKLINIK = "17";
                    }else if($row->UNIT == '163'){
                        $TOTALLPA += $row->TARIFRS;
                        $DOKTERLPA = 884;
                        $ANALISLABKLINIK = "18";
                    }
                    
                    
                }
                if(in_array($row->id_kategori, [15])){
                        
                   $TOTALBANKDARAH += $row->TARIFRS;
                   $PENATABANKDARAH = 19;
                    
                }
               
                if(in_array($row->id_kategori, [21])){
                    $HD  = $row->KDDOKTER;
                    $DOKTERHDRANAP = $row->KDDOKTER;
                    $TOTALHD += $row->TARIFRS;
                    $PERAWAT_HD_RANAP = 8;
                }
                if(in_array($row->id_kategori, [38,27])){
                  $AHLIGIZI = 15;
                  $TAHLIGIZI += 1;
                }
                if(in_array($row->KODETARIF, ['07'])){
                    $Apoteker = 6;
                    $EMBALACE += 1;
                }
            }
        
            
        
            $data_sumber = [
                "HARGA" => $TINDAKANRAJAL_HARGA,
                "EMBALACE" => $EMBALACE,
                "AHLIGIZI"=>$TAHLIGIZI,
                "TOTALPATKLIN" => $TOTALPATKLIN,
                "TOTALLPA" => $TOTALLPA,
                "TOTALRADIOLOGI" => $TOTALRADIOLOGI,
                "TOTALBDRS" => $TOTALBDRS,
                "VERIFIKASITOTAL" => $VERIFIKASITOTAL,
                "TOTALHD" => $TOTALHD,
                "TOTALBANKDARAH" => $TOTALBANKDARAH
            ];
           
          
          
            
            // cari data proporsi
            $proporsi_fairness = ProporsiFairness::
            where('grade', $grade)
            ->where('groups', ($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL")
            ->where('jenis', ($pisau)?"PISAU":"NONPISAU")
            ->get();
            
            
            
            $pembagian = [];
            
            if(count($kddokter) > 0 && $kddokter[0] != ""){
                $dpjpraber = $this->groupAndCount($kddokter);
                if(count($dpjpraber['filtered']) > 1){
                    $DPJPRABER  =$tadmission->dokter_penanggungjawab;
                    $notdpjp = current(array_filter($dpjpraber['most_frequent']['value'], fn($val) => $val !== $DPJP));
                    $DOKTERRABER = $notdpjp;
                    $DPJP = "";
               }else{
                    
                    $notdpjp = current(array_filter($dpjpraber['most_frequent']['value'], fn($val) => $val !== $DPJP));
                    if(!$notdpjp == ""){
                        $DOKTERKONSUL = $tadmission->dokter_penanggungjawab;
                        $KONSULEN = $notdpjp;
                        $DPJP = "";
                    }

                   
               }
              
            }
        
           
           
            $divisi = Divisi::pluck('nama', 'id');
            $total_remunerasi = 0;
            $proporsi_fairness_radiologi = [];
            $proporsi_fairness_laboratorist = [];
             
            foreach($proporsi_fairness as $row){
                
              
                if(@${$row['ppa']} != "" && @${$row['ppa']} != 0){
    
                    $divisi_id = $divisi->search(function ($item, $key) use ($row) {
                        return $item == $row->ppa;
                    });
    
    
                    if($divisi_id !== false){
                        $nama_dokter = $row->ppa;
                        $kode_dokter = $divisi_id;
                        if($row->ppa == "Dokter_Umum_IGD"){
                            $cluster = 1;
                        }else if($row->ppa == "STRUKTURAL"){
                            $cluster = 3;
                        }else if($row->ppa == "JTL"){
                            $cluster = 4;
                        }else{
                            $cluster = 2;
                        }
                    }else{
                        $dokter = Dokter::where('KDDOKTER', @${$row['ppa']})->first();
                        $nama_dokter = $dokter->NAMADOKTER;
                        $kode_dokter = @${$row['ppa']};
                        $cluster = 1;
                    }
                    
                    if($nama_dokter == ""){
                        $kode_dokter = 0;
                        $nilai_remunerasi = 0;
                    }
    
                    if($row['sumber'] == "HARGA"){
                        if($row['value'] > 1 ){
                            if($row['ppa'] == "AHLIGIZI"){
                                $nilai_remunerasi = (int)$row['value'] * $data_sumber[$row['ppa']];
                            }else{
                                $nilai_remunerasi = $row['value'];
                            }
                          
                        }else{
                            $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                        }
                        
                    }else if($row['sumber'] == "EMBALACE"){
                        $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                    }
                    else{
                        $nilai_remunerasi = $data_sumber[$row['sumber']]*$row['value'];
                    }
    
                  
                    
                }else{
                    $nilai_remunerasi = 0;
                    $nama_dokter = "";
                    $kode_dokter = 0;
    
                }
    
                
                if($nilai_remunerasi > 0){   
                   
                    $data = [
                        'groups'=>$row['groups'],
                        'jenis'=>$row['jenis'],
                        'grade'=>$grade,
                        'ppa'=>$row['ppa'],
                        'value'=>$row['value'],
                        'sumber'=>$row['sumber'],
                        'flag'=>$row['flag'],
                        'del'=>$row['del'],
                        'sep'=>$data_detail_source->no_sep,
                        'id_detail_source'=>$data_detail_source->id,
                        'cluster'=>$cluster,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr,
                        'tanggal'=>$data_detail_source->tgl_verifikasi,
                        'nama_ppa'=>$nama_dokter,
                        'kode_dokter'=>@$kode_dokter,
                        'sumber_value'=>$data_sumber[$row['sumber']],
                        'nilai_remunerasi'=>$nilai_remunerasi,
                        'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                    ]; 
                    $total_remunerasi += $nilai_remunerasi;        
                         
                    $savePembagianKlaim = PembagianKlaim::create($data);
                }
               
                if($row['ppa'] == "Dokter_Umum_IGD"){
                    $proporsi_fairness_umum_igd = $row;
                }

            }
           
            
            if( $TOTALBANKDARAH > 0){
                $dokter_bankdarah = [705,133];
                $persentase_bankdarah = [0.03,0.02];
                foreach($dokter_bankdarah as $key => $dokter){
                    $nama_dokter = Dokter::where('KDDOKTER', $dokter)->first()->NAMADOKTER;
                    $data = [
                        'groups'=>($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL",
                        'jenis'=>$data_detail_source->jenis,
                        'grade'=>$grade,
                        'ppa'=>"Dokter_Bank_Darah",
                        'value'=>$persentase_bankdarah[$key],
                        'sumber'=>'TOTALBANKDARAH',
                        'flag'=>'',
                        'del'=>0,
                        'sep'=>$data_detail_source->no_sep,
                        'id_detail_source'=>$data_detail_source->id,
                        'cluster'=>1,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr,
                        'tanggal'=>$data_detail_source->tgl_verifikasi,
                        'nama_ppa'=>$nama_dokter,
                        'kode_dokter'=>@$dokter,
                        'sumber_value'=>($data_sumber['TOTALBANKDARAH']),
                        'nilai_remunerasi'=>$persentase_bankdarah[$key]*$data_sumber['TOTALBANKDARAH'],
                        'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                    ];   
                    $total_remunerasi += $persentase_bankdarah[$key]*$data_sumber['TOTALBANKDARAH'];  
                    $savePembagianKlaim = PembagianKlaim::create($data);
                }
                
            }
            
            if(count($dokters_umum) > 0){
                foreach($dokters_umum as $dokter){
                    $nama_dokter = Dokter::where('KDDOKTER', $dokter)->first()->NAMADOKTER;
                
                    $data = [
                        'groups'=>($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL",
                        'jenis'=>$data_detail_source->jenis,
                        'grade'=>$grade,
                        'ppa'=>"Dokter_Umum",
                        'value'=>$proporsi_fairness_umum_igd['value'],
                        'sumber'=>'VERIFIKASITOTAL',
                        'flag'=>'',
                        'del'=>0,
                        'sep'=>$data_detail_source->no_sep,
                        'id_detail_source'=>$data_detail_source->id,
                        'cluster'=>1,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr,
                        'tanggal'=>$data_detail_source->tgl_verifikasi,
                        'nama_ppa'=>$nama_dokter,
                        'kode_dokter'=>@$dokter,
                        'sumber_value'=>(1/count($dokters_umum))*$data_sumber['VERIFIKASITOTAL'],
                        'nilai_remunerasi'=>(1/count($dokters_umum))*$proporsi_fairness_umum_igd['value']*$data_sumber['VERIFIKASITOTAL'],
                        'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                    ];   
                    $total_remunerasi += (1/count($dokters_umum))*$proporsi_fairness_umum_igd['value']*$data_sumber['VERIFIKASITOTAL'];  
                    $savePembagianKlaim = PembagianKlaim::create($data);
                }
            }
          
    
            // RADIOLOGIST
         
          
            

           
            $data['total_remunerasi'] = $total_remunerasi;
            if($data_detail_source->biaya_disetujui == 0){
                $data['persentase_remunerasi'] = 0;
            }else{
                $data['persentase_remunerasi'] = round($total_remunerasi/$data_detail_source->biaya_disetujui*100, 2);
            }
           
            
            if($savePembagianKlaim){
                if($data_detail_source->biaya_disetujui == 0){
                    
                    $update = DetailSource::where('id', $detailSource->id)
                    ->update([
                            'status_pembagian_klaim'=>1,
                            'idxdaftar'=>$idxdaftar,
                            'biaya_disetujui'=>$VERIFIKASITOTAL,
                            'total_remunerasi'=>$total_remunerasi,
                            'nomr'=>$nomr
                        ]);
                }else{
                    $update = DetailSource::where('id', $detailSource->id)
                    ->update([
                            'status_pembagian_klaim'=>1,
                            'idxdaftar'=>$idxdaftar,
                            'total_remunerasi'=>$total_remunerasi,
                            'nomr'=>$nomr
                        ]);
                }

               
                $success += 1;
                $failed += 0;
                    $message[] = "data $detailSource->no_sep berhasil diproses";
    
            }else{
                $update = DetailSource::where('id', $detailSource->id)
            ->update([
                    'status_pembagian_klaim'=>2
                ]);
                $failed += 1;
                $success += 0;
                $message[] = "data $detailSource->no_sep gagal diproses";
            }
            
        }
       
        return [
            "failed"=>$failed,
            "success"=>$success,
            "message"=>$message,
            "data"=>$data_detail_source
        ];
    }
    
    
    
    function groupAndCount(array $data): array {
        // Hitung jumlah kemunculan
        if(!is_array($data)){
            return [];
        }
        $counted = array_count_values($data);
    
        // Ambil hanya elemen yang muncul lebih dari 1 kali
        $filtered = array_filter($counted, fn($count) => $count > 1);
    
        // Jika tidak ada yang muncul lebih dari 1 kali
        if (empty($filtered)) {
           
            $maxValue = max($counted);
            $minValue = min($counted);
            $mostFrequent = array_keys($counted, $maxValue);
            $minFrequent = array_keys($counted, $minValue);
            return [
                'filtered' => [],
                'most_frequent' => [
                    'value' => $mostFrequent,
                    'count' => $maxValue
                ],
                'min_frequent' => [
                    'value' => $minFrequent,
                    'count' => $minValue
                ]
            ];
        }
    
        // Cari jumlah terbanyak
        $maxValue = max($filtered);
        $minValue = min($filtered);
    
        // Ambil semua elemen yang muncul sebanyak nilai maksimum
        $mostFrequent = array_keys($filtered, $maxValue);
        $minFrequent = array_keys($filtered, $minValue);
    
        return [
            'filtered' => $filtered,
            'most_frequent' => [
                'value' => $mostFrequent,
                'count' => $maxValue
            ],
            'min_frequent' => [
                'value' => $minFrequent,
                'count' => $minValue
            ]
        ];
    }
    public function updateSepPasien(Request $request) {

        header('Content-Type: application/json');
        $id = $request->id;
        $detailSource = DetailSource::where('id', 'like', '' . $id . '')->orWhere('no_sep', 'like', '' . $id . '');
   
        if($detailSource->count() == 0){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        $data_detail_source = $detailSource->first();
        // if($data_detail_source->status_pembagian_klaim == 1){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Data sudah diproses'
        //     ]);
        // }
    
      $hitung = $this->hitung($data_detail_source->id_remunerasi_source, $data_detail_source);
    
       return response()->json([
        'success' => true,
        'message' => 'Success',
        'data' => $hitung
      ]);
     
    }
   

    private function formatBillingData($data, $type = 'ranap')
    {
        if ($data->isEmpty()) {
            return [];
        }

        $result = [];
        $totalKeseluruhan = 0;

        // Kelompokkan data berdasarkan unit
        $units = [
            'ruang' => [
                'nama' => 'Ruang',
                'unit_code' => 19,
                'data' => [],
                'total' => 0
            ],
            'laboratorium' => [
                'nama' => 'Instalasi Laboratorium',
                'unit_code' => 16,
                'data' => [],
                'total' => 0
            ],
            'radiologi' => [
                'nama' => 'Instalasi Radiologi',
                'unit_code' => 17,
                'data' => [],
                'total' => 0
            ],
            'kamar_operasi' => [
                'nama' => 'Kamar Operasi',
                'unit_code' => 15,
                'data' => [],
                'total' => 0
            ],
            'farmasi' => [
                'nama' => 'Instalasi Farmasi',
                'unit_code' => 14,
                'data' => [],
                'total' => 0
            ]
        ];

        foreach ($data as $item) {
            foreach ($units as $key => $unit) {
                if ($item->UNIT == $unit['unit_code']) {
                    $units[$key]['data'][] = [
                        'nama_tindakan' => $item->nama_tindakan,
                        'NAMADOKTER' => $item->NAMADOKTER,
                        'CARABAYAR' => $item->CARABAYAR,
                        'TANGGAL' => $item->TANGGAL,
                        'QTY' => $item->QTY,
                        'TARIFRS' => $item->TARIFRS,
                        'TOTAL' => $item->QTY * $item->TARIFRS
                    ];
                    $units[$key]['total'] += $item->QTY * $item->TARIFRS;
                    $totalKeseluruhan += $item->QTY * $item->TARIFRS;
                }
            }
        }

        // Hanya masukkan unit yang memiliki data
        foreach ($units as $key => $unit) {
            if (!empty($unit['data'])) {
                $result[$key] = [
                    'nama' => $unit['nama'],
                    'data' => $unit['data'],
                    'total' => $unit['total']
                ];
            }
        }

        $result['total_keseluruhan'] = $totalKeseluruhan;
        return $result;
    }

    function ambilNoMR($json) {
        $data = json_decode($json, true);
    
        if (
            isset($data['response']['sep']['peserta']['noMr']) &&
            !empty($data['response']['sep']['peserta']['noMr'])
        ) {
            return $data['response']['sep']['peserta']['noMr'];
        }
    
        return null; // atau bisa return string error
    }
    
    function getIdxDaftar($sep) {
        if(strpos($sep,"-") !== false){
            $tpendaftaran = Tpendaftaran::where('IDXDAFTAR', $sep)->first();
            if($tpendaftaran){
                $idxdaftar = $tpendaftaran->IDXDAFTAR;
                $nomr = $tpendaftaran->NOMR;
            }
        }else{
            $detailSource = DetailSource::where('no_sep', $sep)->where('idxdaftar', '>', 1);
            if($detailSource->count() > 0){
                $idxdaftar = $detailSource->orderBy('idxdaftar', 'desc')->first()->idxdaftar;
                $nomr = $detailSource->orderBy('idxdaftar', 'desc')->first()->nomr;
            }else{
                $tbpjs = Sepbpjs::where('noSep', $sep)->first();
                if($tbpjs){
                    $idxdaftar = $tbpjs->idxdaftar;
                    $nomr = $tbpjs->peserta_noMr;
                    if($nomr == ""){
                        $response = $tbpjs->responseJSON;
                        $nomr = $this->ambilNoMR($response);
                    }
                    if($nomr == ""){
                        
                        $datasep = $this->getApi("http://192.168.10.5/bpjs_2/cari_pasien/cari_idx2.php?q=".$sep);
                        $data = json_decode($datasep);
                        if(@$data->success){
                            $idxdaftar = $data->data->idxdaftar;
                            $nomr = $data->data->nomr;
                        }else{
                            $pendaftaran = Tpendaftaran::where('IDXDAFTAR', $idxdaftar);
                            if($pendaftaran->count() > 0){
                                $pendaftaran = $pendaftaran->first();
                                $nomr = $pendaftaran->NOMR;
                            }

                        }
                        
                    
                    }
                
                    
                
                }else{
                
                    $datasep = $this->getApi("http://192.168.10.5/bpjs_2/cari_pasien/cari_idx2.php?q=".$sep);
                    $data = json_decode($datasep);
            
                    
                    if($data->success){
                        $idxdaftar = $data->data->idxdaftar;
                        $nomr = $data->data->nomr;
                    }else{
                        return [
                            'idxdaftar' => "",
                            'nomr' => ""
                        ];
                    }
                
                
                }

            }
        }
        
        
        return [
            'idxdaftar' => $idxdaftar,
            'nomr' => $nomr
        ];

        
    }
    private function getApi($url)
    {
       
        $headers = array(
            "User-Agent: PHP-SDK",
            "Accept: */*",
            "kode:cahmbarek",
            "Content-type: application/json",
            "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjQiLCJ1c2VybmFtZSI6InVzZXIiLCJpYXQiOjE1ODExMzg5OTEsImV4cCI6MTU4MTE1Njk5MX0.M__6_FFWgD5Uk7f3vvvW9FE517k5HebNEzALEWUCcKQ"
        );
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch); 
        // menampilkan hasil curl
        return $output;
    }

    /**
     * Menyimpan pembagian klaim baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'groups' => 'required|string|max:20',
            'jenis' => 'required|string|max:20',
            'grade' => 'required|string|max:20',
            'ppa' => 'required|string|max:50',
            'value' => 'required|numeric|min:0',
            'sumber' => 'nullable|string|max:50',
            'flag' => 'nullable|string|max:20',
            'sep' => 'nullable|string|max:50',
            'id_detail_source' => 'required|exists:detail_source,id',
            'cluster' => 'nullable|integer|min:1|max:4',
            'idxdaftar' => 'nullable|integer',
            'nomr' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            PembagianKlaim::create($request->all());
            return ResponseFormatter::success(null, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan pembagian klaim.
     */
    public function show($id)
    {
        try {
            $data = PembagianKlaim::with(['detailSource' => function($query) {
                $query->with('remunerasiSource');
            }])
            ->where('id', $id)
            ->where('del', false)
            ->firstOrFail();

            // Format nilai remunerasi untuk tampilan
            $data->nilai_remunerasi_formatted = number_format($data->nilai_remunerasi, 2, ',', '.');
            $data->sumber_value_formatted = number_format($data->sumber_value, 2, ',', '.');
            $data->value_formatted = number_format($data->value, 4, ',', '.');
            
            // Format tanggal
            $data->tanggal_formatted = $data->tanggal ? Carbon::parse($data->tanggal)->format('d/m/Y') : '-';

            // Tambahkan informasi cluster
            $data->cluster_name = match($data->cluster) {
                1 => 'Dokter',
                2 => 'Perawat',
                3 => 'Penunjang',
                4 => 'Administrasi',
                default => 'Tidak Diketahui'
            };

            if ($data->detailSource) {
                // Format biaya untuk detail source
                $data->detailSource->biaya_disetujui_formatted = number_format($data->detailSource->biaya_disetujui, 2, ',', '.');
                $data->detailSource->biaya_riil_rs_formatted = number_format($data->detailSource->biaya_riil_rs, 2, ',', '.');
                
                // Hitung selisih dan persentase
                $selisih = $data->detailSource->biaya_disetujui - $data->detailSource->biaya_riil_rs;
                $persentase = ($selisih / $data->detailSource->biaya_disetujui) * 100;
                
                $data->detailSource->selisih_formatted = number_format($selisih, 2, ',', '.');
                $data->detailSource->persentase_selisih = number_format($persentase, 2, ',', '.');
            }

            return ResponseFormatter::success($data, 'Data pembagian klaim berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data pembagian klaim tidak ditemukan: ' . $e->getMessage());
        }
    }
    

    /**
     * Mengupdate pembagian klaim.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'groups' => 'required|string|max:20',
            'jenis' => 'required|string|max:20',
            'grade' => 'required|string|max:20',
            'ppa' => 'required|string|max:50',
            'value' => 'required|numeric|min:0',
            'sumber' => 'nullable|string|max:50',
            'flag' => 'nullable|string|max:20',
            'sep' => 'nullable|string|max:50',
            'id_detail_source' => 'required|exists:detail_source,id',
            'cluster' => 'nullable|integer|min:1|max:4',
            'idxdaftar' => 'nullable|integer',
            'nomr' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $pembagianKlaim = PembagianKlaim::findOrFail($id);
            $pembagianKlaim->update($request->all());
            return ResponseFormatter::success(null, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus pembagian klaim.
     */
    public function destroy($id)
    {
        try {
            $pembagianKlaim = PembagianKlaim::findOrFail($id);
            $pembagianKlaim->update(['del' => true]);
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan pembagian klaim berdasarkan detail source.
     */
    public function listByDetailSource($detailSourceId)
    {
        try {
            $detailSource = DetailSource::with('remunerasiSource')->findOrFail($detailSourceId);
            return view('pembagian-klaim.list', compact('detailSource'));
        } catch (\Exception $e) {
            return redirect()->route('detail-source.index')
                ->with('error', 'Detail source tidak ditemukan');
        }
    }

    /**
     * Get data pembagian klaim berdasarkan detail source untuk DataTables.
     */
    public function getByDetailSource(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = PembagianKlaim::where('id_detail_source', $id)
                                 ->where('del', false);
                                 
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                      
                    ';
                      // <a href="#" data-url="' . route('pembagian-klaim.show', $row->id) . '" class="btn btn-info btn-sm btn-edit" title="Edit">
                        //     <i class="ti ti-pencil"></i>
                        // </a>
                        // <a href="#" data-url="' . route('pembagian-klaim.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                        //     <i class="ti ti-trash"></i>
                        // </a>
                })
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('value', function($row) {
                    return number_format($row->value, 4, ',', '.');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return abort(404);
    }
    public function getByDetailSourcebySource(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = PembagianKlaim::where('remunerasi_source_id', $id)
                                  ->where('del', false);
            

            
            // Apply filters
            if ($request->has('filter_nama_ppa') && !empty($request->filter_nama_ppa)) {
                $query->where('nama_ppa', 'like', '%' . $request->filter_nama_ppa . '%');
            }
            
            if ($request->has('filter_sumber') && !empty($request->filter_sumber)) {
                $query->where('sumber', 'like', '%' . $request->filter_sumber . '%');
            }
            
            if ($request->has('filter_cluster') && !empty($request->filter_cluster)) {
                $query->where('cluster', $request->filter_cluster);
            }
            
            if ($request->has('filter_ppa') && !empty($request->filter_ppa)) {
                $query->where('ppa', 'like', '%' . $request->filter_ppa . '%');
            }
            
            if ($request->has('filter_grade') && !empty($request->filter_grade)) {
                $query->where('grade', 'like', '%' . $request->filter_grade . '%');
            }
            
            if ($request->has('filter_jenis') && !empty($request->filter_jenis)) {
                $query->where('jenis', 'like', '%' . $request->filter_jenis . '%');
            }
                                 
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('pembagian-klaim.show', $row->id) . '" class="btn btn-info btn-sm btn-edit" title="Edit">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <a href="#" data-url="' . route('pembagian-klaim.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                            <i class="ti ti-trash"></i>
                        </a>
                    ';
                })
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal ? $row->tanggal->format('d/m/Y') : '-';
                })
                ->addColumn('nilai_remunerasi', function($row) {
                    $nilai = $row->nilai_remunerasi ?: $row->value ?: 0;
                    return number_format($nilai, 0, ',', '.');
                })
                ->editColumn('cluster', function($row) {
                    return 'Cluster ' . $row->cluster;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return abort(404);
    }

    public function getFilterDataBySource(Request $request, $id)
    {
        if ($request->ajax()) {
            $filters = [
                'nama_ppa' => [
                    "AHLIGIZI",
                    "ANALISLABKLINIK",
                    "ASISTEN",
                    "Abdul Kohar,dr. Sp.U",
                    "Ahmad Husin,Sp.PD,M.Kes",
                    "Aji Patriajati, dr. Sp.OG",
                    "Akbar Mafaza, dr. Sp.OT",
                    "Albert Tri Rustamaji, dr., Sp.PD",
                    "Alfiyannul Akhsan, dr. Sp.B, Sp.B (K) Onk",
                    "Aminah,dr,M.Sc,Sp.PK",
                    "Andhika Aryandhie Dwiputra, dr",
                    "Apoteker",
                    "Aqilla Tiara Kartikaningtyas, drg. Sp.KG",
                    "Ardhian Noor Wicaksono, dr. Sp.THT-KL",
                    "Ari Jaka Setiawan,dr.,Sp.B",
                    "Bayu Kurniawan Fitra, dr",
                    "Bela Bagus Setiawan,dr. SP.PA",
                    "Bobby Kennedy, dr. Sp. K.F.R, M.Ked.Klin",
                    "Budi Wahono dr. SpAn",
                    "Desyana Indira Putri,dr",
                    "Dewi Novitasari Arifin, dr. Sp. BA",
                    "Dinar Nastiti,dr",
                    "Dwi Marhendra K D, dr. SpP",
                    "Dyah Ariyantini, dr.,Sp.OG",
                    "Eddy Cahyono, drg Sp.KGA",
                    "Eddy Mulyono, dr., Sp.PD FINASIM",
                    "Eka Handika Septistalia Anggraeni dr.",
                    "Eko Sugihanto, dr. Sp.PD, FINASIM",
                    "Enny Rohmawati dr. Sp.PK",
                    "Erna Kristiyani, dr. Sp.KK",
                    "Fetria Melani, dr. Sp.GK",
                    "Giri Yurista, dr. B",
                    "Hari Wahono Satrioaji, dr. Sp. S",
                    "Heni Handayani,dr. Sp.An",
                    "Hera Dwi Prihati, dr",
                    "Heroe Joenianto, dr. SpM",
                    "Hesti Kartika Sari, dr. Sp.A",
                    "Hesti Mustiko Rini,dr",
                    "I Gusti Nyoman Panji Putu Gawa,dr.Sp.An",
                    "Ifrinda, dr. SpOG",
                    "Isfandiyar Fahmi, dr., Msi,Med, Sp.A",
                    "Iwan Prasetyo, dr. SpOG",
                    "JTL",
                    "Jeanne Koernia Melati dr.",
                    "Joko Mardianto dr.",
                    "Khozin Hasan, dr. SpOT",
                    "M. Arifin, dr. Sp.B-KBD",
                    "Musdalifah dr.,Sp.Rad",
                    "Mustika Mahbubi, dr. Sp.JP, FIHA",
                    "Nabila Syifa Marta Widanti, dr. Sp.KJ",
                    "Nefrizal Wicaksono, dr. Sp. An-Ti",
                    "Nimas Putri Pertiwi, dr",
                    "Novy Oktaviana, dr. Sp. D.V.E",
                    "Oktarina Nila Juwita, dr. SpM",
                    "PENATA",
                    "PENATABANKDARAH",
                    "PERAWAT",
                    "PERAWATHDRAJAL",
                    "Perawat / Bidan",
                    "RADIOGRAFER",
                    "Reni Kurniawati, dr",
                    "Rofii, dr. SpOT",
                    "Rokhmad Widiatma, dr.,Sp.Rad",
                    "STRUKTURAL",
                    "Setyo Wulandari, dr",
                    "Shofa Aji Setyoko, dr",
                    "Siti Aisyah Elfa dr. Sp.JP",
                    "Siti Fatkhurrohmah, S.Psi",
                    "Siti Munawaroh dr.",
                    "Siti Nurhikmah,dr,Sp.THT.KL,M.Kes",
                    "Sri Ekawati, dr.  Sp.KK",
                    "Sunaryo,dr. M.Kes, SpS",
                    "Supramestiningsih dr.",
                    "Suranti, dr. Sp.A",
                    "Terapis",
                    "Widi Antono, dr.,M.Kes, Sp.B",
                    "Yarmaji, dr.Sp.KJ",
                    "Yoseph Dwi Kurniawan, dr. Sp.P"
                ],
                'sumber' => [
                    "EMBALACE",
                    "HARGA",
                    "TOTALBANKDARAH",
                    "TOTALHD",
                    "TOTALLPA",
                    "TOTALPATKLIN",
                    "TOTALRADIOLOGI",
                    "VERIFIKASITOTAL"
                ],
                'cluster' => [
                    1,
                    2,
                    3,
                    4
                ],
                'ppa' => [
                    "AHLIGIZI",
                    "ANALISLABKLINIK",
                    "ANESTESI",
                    "ASISTEN",
                    "Apoteker",
                    "DOKTERHDRANAP",
                    "DOKTERKONSUL",
                    "DOKTERLPA",
                    "DOKTERRABER",
                    "DPJP",
                    "DPJPRABER",
                    "Dokter_Bank_Darah",
                    "Dokter_Umum",
                    "JTL",
                    "KONSULEN",
                    "LABORATORIST",
                    "PENATA",
                    "PENATABANKDARAH",
                    "PERAWAT",
                    "PERAWATHDRAJAL",
                    "RADIOGRAFER",
                    "RADIOLOGIST",
                    "STRUKTURAL",
                    "TINDAKANRAJAL"
                ],
                'grade' => [
                    "GRADE1",
                    "GRADE2",
                    "GRADE3"
                ],
                'jenis' => [
                    "NONPISAU",
                    "PISAU",
                    "Rawat Inap",
                    "Rawat Jalan"
                ]
            ];

            return response()->json([
                'status' => 'success',
                'data' => $filters
            ]);
        }

        return abort(404);
    }

    /**
     * Import data dari Excel
     */
    public function import(Request $request, $detailSourceId)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls|max:2048'
        ], [
            'file.required' => 'File harus diupload',
            'file.file' => 'Upload harus berupa file',
            'file.mimes' => 'Format file harus xlsx atau xls',
            'file.max' => 'Ukuran file maksimal 2MB'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $file = $request->file('file');
            $action = $request->query('action', 'process');

            // Prepare import
            if ($action === 'prepare') {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                array_shift($rows); // Remove header

                // Filter out empty rows
                $rows = array_filter($rows, function($row) {
                    return !empty(array_filter($row));
                });

                $totalRows = count($rows);
                $chunkSize = 1000; // Process 1000 rows per chunk
                $totalChunks = ceil($totalRows / $chunkSize);

                // Store the file temporarily
                $tempPath = storage_path('app/temp');
                if (!file_exists($tempPath)) {
                    mkdir($tempPath, 0777, true);
                }
                $tempFile = $tempPath . '/import_' . time() . '.xlsx';
                $file->move($tempPath, basename($tempFile));

                // Store import session data
                session([
                    'import_file' => $tempFile,
                    'total_rows' => $totalRows,
                    'chunk_size' => $chunkSize,
                    'total_chunks' => $totalChunks
                ]);

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'total_rows' => $totalRows,
                        'total_chunks' => $totalChunks
                    ]
                ]);
            }

            // Process chunk
            if ($action === 'process') {
                $chunk = $request->input('chunk', 1);
                $tempFile = session('import_file');
                $chunkSize = session('chunk_size');

                if (!file_exists($tempFile)) {
                    return ResponseFormatter::error(null, 'File import tidak ditemukan', 404);
                }

                $spreadsheet = IOFactory::load($tempFile);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                array_shift($rows); // Remove header

                // Get chunk of rows
                $start = ($chunk - 1) * $chunkSize;
                $chunkRows = array_slice($rows, $start, $chunkSize);

                $success = 0;
                $failed = 0;
                $errors = [];

                foreach ($chunkRows as $index => $row) {
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    $rowData = [
                        'groups' => $row[0],
                        'jenis' => $row[1],
                        'grade' => $row[2],
                        'ppa' => $row[3],
                        'value' => $this->transformToDecimal($row[4]),
                        'sumber' => $row[5],
                        'flag' => $row[6],
                        'sep' => $row[7],
                        'id_detail_source' => $detailSourceId,
                        'cluster' => (int)$row[8],
                        'idxdaftar' => (int)$row[9],
                        'nomr' => (int)$row[10],
                        'tanggal' => $this->transformDate($row[11])
                    ];

                    $rowValidator = Validator::make($rowData, [
                        'groups' => 'required|string|max:20',
                        'jenis' => 'required|string|max:20',
                        'grade' => 'required|string|max:20',
                        'ppa' => 'required|string|max:50',
                        'value' => 'required|numeric|between:0,9999999.9999',
                        'sumber' => 'required|string|max:50',
                        'flag' => 'required|string|max:20',
                        'sep' => 'required|string|max:50',
                        'id_detail_source' => 'required|exists:detail_source,id',
                        'cluster' => 'required|integer|between:1,4',
                        'idxdaftar' => 'required|integer',
                        'nomr' => 'required|integer',
                        'tanggal' => 'required|date'
                    ]);

                    if ($rowValidator->fails()) {
                        $failed++;
                        $errors[] = "Baris " . ($start + $index + 2) . ": " . implode(', ', $rowValidator->errors()->all());
                        continue;
                    }

                    try {
                        PembagianKlaim::create($rowData);
                        $success++;
                    } catch (\Exception $e) {
                        $failed++;
                        $errors[] = "Baris " . ($start + $index + 2) . ": Gagal menyimpan data";
                    }
                }

                // If this is the last chunk, clean up
                if ($chunk == session('total_chunks')) {
                    unlink($tempFile);
                    session()->forget(['import_file', 'total_rows', 'chunk_size', 'total_chunks']);
                }

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'success' => $success,
                        'failed' => $failed,
                        'errors' => $errors
                    ]
                ]);
            }

        } catch (\Exception $e) {
            // Clean up on error
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
            session()->forget(['import_file', 'total_rows', 'chunk_size', 'total_chunks']);
            
            return ResponseFormatter::error(null, 'Gagal memproses file: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set judul worksheet
            $sheet->setTitle('Template Pembagian Klaim');

            // Set header kolom
            $headers = [
                'A1' => 'Groups',
                'B1' => 'Jenis',
                'C1' => 'Grade',
                'D1' => 'PPA',
                'E1' => 'Value',
                'F1' => 'Sumber',
                'G1' => 'Flag',
                'H1' => 'SEP',
                'I1' => 'Cluster',
                'J1' => 'Index Daftar',
                'K1' => 'No. RM',
                'L1' => 'Tanggal'
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Set contoh data
            $exampleData = [
                'A2' => 'RITL',
                'B2' => 'PISAU',
                'C2' => 'GRADE1',
                'D2' => 'DPJP',
                'E2' => '100.0000',
                'F2' => 'VERIFIKASITOTAL',
                'G2' => 'NONE',
                'H2' => '0001234567',
                'I2' => '1',
                'J2' => '12345',
                'K2' => '54321',
                'L2' => '01/01/2024'
            ];

            foreach ($exampleData as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Set style header
            $sheet->getStyle('A1:L1')->getFont()->setBold(true);
            $sheet->getStyle('A1:L1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E2E2E2');
            
            // Set lebar kolom otomatis
            foreach(range('A','L') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            // Tambahkan validasi data
            $validation = $sheet->getCell('A2')->getDataValidation();
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"RITL,RJTL"');

            // Set format angka untuk value
            $sheet->getStyle('E2')->getNumberFormat()->setFormatCode('#,##0.0000');

            // Set format angka untuk cluster
            $sheet->getStyle('I2')->getNumberFormat()->setFormatCode('0');

            // Buat writer untuk output
            $writer = new Xlsx($spreadsheet);

            // Set header untuk download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="template_pembagian_klaim.xlsx"');
            header('Cache-Control: max-age=0');

            // Simpan file ke output
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal mengunduh template: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Transform date value from Excel
     */
    private function transformDate($value)
    {
        try {
            if (is_numeric($value)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
            }
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Transform decimal value from Excel
     */
    private function transformToDecimal($value)
    {
        if (is_string($value)) {
            $value = str_replace(',', '', $value);
            return (float) str_replace(['Rp', '.', ','], ['', '', '.'], $value);
        }
        return $value;
    }

    /**
     * Menampilkan laporan pembagian klaim berdasarkan cluster dan nama dokter
     */
    public function laporan(Request $request, $sourceId)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        try {
            // Ambil data remunerasi source
            $remunerasiSource = RemunerasiSource::findOrFail($sourceId);

            // Hitung total klaim
            $total_klaim = DetailSource::where('id_remunerasi_source', $sourceId)
                ->where('status_pembagian_klaim', 1)
                ->sum('biaya_disetujui');

            // Data untuk Dokter (cluster 1)
            $data_dokter = PembagianKlaim::where('remunerasi_source_id', $sourceId)
                ->where('cluster', 1)
                ->get()
                ->groupBy('kode_dokter')
                ->map(function ($group) {
                    return [
                        'total_nominal_remunerasi' => $group->sum('nilai_remunerasi'),
                        'total_pasien_rajal' => $group->filter(function ($item) {
                            return $item->groups == 'RJTL';
                        })->count(),
                        'total_pasien_ranap' => $group->filter(function ($item) {
                            return $item->groups == 'RITL';
                        })->count(),
                        'nama_ppa' => $group->first()->nama_ppa
                    ];
                });
            

            // Data untuk Perawat (cluster 2)
            $data_perawat = PembagianKlaim::where('remunerasi_source_id', $sourceId)
                ->where('cluster', 2)
                ->get()
                ->groupBy('kode_dokter')
                ->map(function ($group) {
                    return [
                        'total_nominal_remunerasi' => $group->sum('nilai_remunerasi'),
                        'nama_ppa' => $group->first()->nama_ppa
                    ];
                });

            // Data untuk Struktural (cluster 3)
            $data_struktural = PembagianKlaim::where('remunerasi_source_id', $sourceId)
                ->where('cluster', 3)
                ->get()
                ->groupBy('kode_dokter')
                ->map(function ($group) {
                    return [
                        'total_nominal_remunerasi' => $group->sum('nilai_remunerasi'),
                        'nama_ppa' => $group->first()->nama_ppa
                    ];
                });

            // Data untuk JTL/Semua Pegawai (cluster 4)
            $data_jtl = PembagianKlaim::where('remunerasi_source_id', $sourceId)
                ->where('cluster', 4)
                ->get()
                ->groupBy('kode_dokter')
                ->map(function ($group) {
                    return [
                        'total_nominal_remunerasi' => $group->sum('nilai_remunerasi'),
                        'nama_ppa' => $group->first()->nama_ppa
                    ];
                });

            // Hitung total remunerasi keseluruhan
            $total_remunerasi = $data_dokter->sum('total_nominal_remunerasi') +
                              $data_perawat->sum('total_nominal_remunerasi') +
                              $data_struktural->sum('total_nominal_remunerasi') +
                              $data_jtl->sum('total_nominal_remunerasi');

            // Format data untuk view
            $formattedData = [
                'remunerasi_source' => [
                    'nama_source' => $remunerasiSource->nama_source,
                    'total_biaya' => number_format($total_klaim, 0, ',', '.'),
                    'total_remunerasi' => number_format($total_remunerasi, 0, ',', '.'),
                    'persentase' => $total_klaim > 0 ? 
                        number_format(($total_remunerasi / $total_klaim) * 100, 2, ',', '.') : '0,00'
                ],
                'data_dokter' => $data_dokter,
                'data_perawat' => $data_perawat,
                'data_struktural' => $data_struktural,
                'data_jtl' => $data_jtl,
                'total_per_kategori' => [
                    'dokter' => $data_dokter->sum('total_nominal_remunerasi'),
                    'perawat' => $data_perawat->sum('total_nominal_remunerasi'),
                    'struktural' => $data_struktural->sum('total_nominal_remunerasi'),
                    'jtl' => $data_jtl->sum('total_nominal_remunerasi')
                ]
            ];

            return view('pembagian-klaim.laporan', $formattedData);
        } catch (\Exception $e) {
            return redirect()->route('remunerasi-source.index')
                ->with('error', 'Gagal menampilkan laporan: ' . $e->getMessage());
        }
    }
} 