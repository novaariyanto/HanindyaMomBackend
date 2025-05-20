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
    public function hitung(Request $request) {
      
        $url = "http://192.168.107.41/simrs_api/api/";
        $databilling = $this->getApi($url."billing/rajal/".$request->idxdaftar."/".$request->nomr);
        return response()->json([
            'message' => 'Success',
            'data' => json_decode($databilling)->data
        ]);
    }
    public function updateSepPasien(Request $request) {
        $sep = $request->sep;
        header('Content-Type: application/json');
        $detailSource =  DetailSource::where('no_sep', $sep);
        $data_detail_source = $detailSource->first();
        if($data_detail_source->status_pembagian_klaim == 1){
            return response()->json([
                'success' => false,
                'message' => 'Data sudah diproses'
            ]);
        }
        $selisih = $data_detail_source->biaya_disetujui-$data_detail_source->biaya_riil_rs;
        $persentase_selisih = $selisih/$data_detail_source->biaya_disetujui;
        $persentase_selisih = $persentase_selisih*100;
        
       $persentase_selisih = round($persentase_selisih, 2);

        $grade = Grade::where('persentase', '>=', $persentase_selisih)
            ->orderBy('persentase', 'ASC')
            ->first();
        
        
        
        if($detailSource->count() > 0){
        
            $grade = $grade->grade;
            $jenis = $data_detail_source->jenis;
           

            if($jenis == 'Rawat Jalan'){
              
                $data = $this->getIdxDaftar($sep);
                $idxdaftar = $data['idxdaftar'];
                $nomr = $data['nomr'];
                
            
                $tpendaftaran = Tpendaftaran::where('IDXDAFTAR', $idxdaftar)->first();
                $databilling = Tbillrajal::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();
                
               
                $VERIFIKASITOTAL = $data_detail_source->biaya_disetujui;
                $pisau = 0; //v
                $TOTALLPA = 0;//v
                $TOTALPATKLIN = 0;//v
                $TOTALRADIOLOGI = 0;//v
                $TOTALBDRS = 0;//
                $TINDAKANRAJAL_HARGA = 0;//
                
                $DPJP = $tpendaftaran->KDDOKTER;
                // ------------	
                $DOKTERKONSUL = "";
                $KONSULEN = "";
                $DPJPRABER = "";
                $DOKTERRABER = "";
                // ------------
                $LABORATORIST = "";
                $RADIOLOGIST = "";
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
                
                
                foreach($data_billing as $row){
                  
                    if(in_array($row->id_kategori, [7,8,9,10,60,64,65])){
                        $pisau += 1;
                        $data_operasi = Moperasi::where(['IDXDAFTAR' => $idxdaftar, 'nomr' => $nomr])->where('status', '!=', 'batal')->get();
                        foreach($data_operasi as $row_operasi){
                            $OPERATOR[] = $row_operasi->kode_dokteroperator;
                            $ANESTESI = $row_operasi->kode_dokteranastesi;
                        }
                        $PENATA = "127";
                        $ASISTEN = "127";
                    }
                    if(in_array($row->id_kategori, [3,41,30,4,5,6,28,22,23,24,25,26,27,29,30])){
                        $TINDAKANRAJAL_HARGA += $row->TARIFRS;
                        $TINDAKANRAJAL = $row->KDDOKTER;
                    }
                    if(in_array($row->id_kategori, [14])){
                        
                        if($row->UNIT == '16'){
                            $TOTALPATKLIN += $row->TARIFRS;
                            $LABORATORIST = $row->KDDOKTER;
                        }else if($row->UNIT == '163'){
                            $TOTALLPA += $row->TARIFRS;
                            $DOKTERLPA = $row->KDDOKTER;
                        }
                       
                    }
                    if(in_array($row->id_kategori, [16,17,18,19])){
                        $TOTALRADIOLOGI += $row->TARIFRS;
                        $RADIOLOGIST = $row->KDDOKTER;
                    }
                    if(in_array($row->id_kategori, [21])){
                        $HD  = $row->KDDOKTER;
                        $DOKTERHDRAJAL = $row->KDDOKTER;
                        $PERAWATHDRAJAL = 127;
                    }
                    


                }
                
                $data_sumber = [
                    "HARGA" => $TINDAKANRAJAL_HARGA,
                    "TOTALPATKLIN" => $TOTALPATKLIN,
                    "TOTALLPA" => $TOTALLPA,
                    "TOTALRADIOLOGI" => $TOTALRADIOLOGI,
                    "TOTALBDRS" => $TOTALBDRS,
                    "VERIFIKASITOTAL" => $VERIFIKASITOTAL
                ];

                
                // cari data proporsi
                $proporsi_fairness = ProporsiFairness::
                where('grade', $grade)
                ->where('groups', ($jenis == 'Rawat Jalan')?"RJTL":"RITL")
                ->where('jenis', ($pisau)?"PISAU":"NONPISAU")
                ->get();
                
                $pembagian = [];

                foreach($proporsi_fairness as $row){
                    
                    if(@${$row['ppa']}){
                        $nama_dokter = Dokter::where('KDDOKTER', @${$row['ppa']})->first()->NAMADOKTER;
                        if($row['sumber'] == "HARGA"){
                            if($row['value'] > 1 ){
                                $nilai_remunerasi = $row['value'];
                            }else{
                                $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                            }
                           
                        }else{
                            
                            $nilai_remunerasi = $data_sumber[$row['sumber']]*$row['value'];
                        }
                        $kode_dokter = @${$row['ppa']};
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
                            'cluster'=>($kode_dokter == 127)?2:1,
                            'idxdaftar'=>$idxdaftar,
                            'nomr'=>$nomr,
                            'tanggal'=>$data_detail_source->tgl_verifikasi,
                            'nama_ppa'=>$nama_dokter,
                            'kode_dokter'=>$kode_dokter,
                            'sumber_value'=>$data_sumber[$row['sumber']],
                            'nilai_remunerasi'=>$nilai_remunerasi
                        ];              
                        $savePembagianKlaim = PembagianKlaim::create($data);
                    }
                }
             
              
                if($savePembagianKlaim){
                    $detailSource->update([
                        'status_pembagian_klaim'=>1,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr
                    ]);
                }
                
                 
            }else if($jenis == 'Rawat Inap'){
                
                $url = "http://192.168.107.41/simrs_api/api/";
                $data = $this->getIdxDaftar($sep);
                $idxdaftar = $data['idxdaftar'];
                $nomr = $data['nomr'];

             
                
                $tadmission = Tadmission::where('id_admission', $idxdaftar)->first();
                $databilling = Tbillranap::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();


                $VERIFIKASITOTAL = $data_detail_source->biaya_disetujui;
                $pisau = 0; //
                $TOTALLPA = 0;//
                $TOTALPATKLIN = 0;//
                $TOTALRADIOLOGI = 0;//
                $TOTALBDRS = 0;//
                $TOTALHD = 0;
                $TINDAKANRAJAL_HARGA = 0;//
                
                $DPJP = $tadmission->dokter_penanggungjawab;
                // ------------	
                $DOKTERKONSUL = "";
                $KONSULEN = "";
                $DPJPRABER = "";
                $DOKTERRABER = "";
                // ------------
                $LABORATORIST = "";
                $RADIOLOGIST = "";
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
                
                
                $kddokter = [];
                
                foreach($databilling as $row){
                    if($row->id_kategori == 2){
                        if(!($row->KDDOKTER== $DPJP )){
                            $kdprofesi = Dokter::where('KDDOKTER', $row->KDDOKTER)->first()->KDPROFESI;
                            if($kdprofesi == 1){
                                $kddokter[] = $row->KDDOKTER;
                                $DPJPRABER  = $tadmission->dokter_penanggungjawab;
                                $DOKTERRABER = $row->KDDOKTER;
                               
                               
                            }
                        }
                    }
                    if(in_array($row->id_kategori, [7,8,9,10,60,64,65])){
                        $pisau += 1;
                        $data_operasi = Moperasi::where(['IDXDAFTAR' => $idxdaftar, 'nomr' => $nomr])->where('status', '!=', 'batal')->get();
                        foreach($data_operasi as $row_operasi){
                            $OPERATOR[] = $row_operasi->kode_dokteroperator;
                            if($row_operasi->kode_dokteranastesi != ""){
                                $ANESTESI = $row_operasi->kode_dokteranastesi;
                            }
                            
                        }

                        $PENATA = "127";
                        $ASISTEN = "127";
                    }
                   
                    if(in_array($row->id_kategori, [14])){
                         
                        if($row->UNIT == '16'){
                            $TOTALPATKLIN += $row->TARIFRS;
                            $LABORATORIST = $row->KDDOKTER;
                        }else if($row->UNIT == '163'){
                            $TOTALLPA += $row->TARIFRS;
                            $DOKTERLPA = $row->KDDOKTER;
                        }
                      
                       
                    }
                    if(in_array($row->id_kategori, [16,17,18,19])){
                        $TOTALRADIOLOGI += $row->TARIFRS;
                        $RADIOLOGIST = $row->KDDOKTER;
                    }
                    if(in_array($row->id_kategori, [21])){
                        $HD  = $row->KDDOKTER;
                        $DOKTERHDRANAP = $row->KDDOKTER;
                        $TOTALHD += $row->TARIFRS;
                        $PERAWATHDRANAP = 127;
                    }
                    


                }
            
                $data_sumber = [
                    "HARGA" => $TINDAKANRAJAL_HARGA,
                    "TOTALPATKLIN" => $TOTALPATKLIN,
                    "TOTALLPA" => $TOTALLPA,
                    "TOTALRADIOLOGI" => $TOTALRADIOLOGI,
                    "TOTALBDRS" => $TOTALBDRS,
                    "VERIFIKASITOTAL" => $VERIFIKASITOTAL,
                    "TOTALHD" => $TOTALHD
                ];

                
                // cari data proporsi
                $proporsi_fairness = ProporsiFairness::
                where('grade', $grade)
                ->where('groups', ($jenis == 'Rawat Jalan')?"RJTL":"RITL")
                ->where('jenis', ($pisau)?"PISAU":"NONPISAU")
                ->get();
              
               
                
                $pembagian = [];
                
                if($DPJPRABER != ""){
                    $DPJP = "";
                }

                foreach($proporsi_fairness as $row){
                    
                    if(@${$row['ppa']} != "" && @${$row['ppa']} != 0){
                        
                        $dokter = Dokter::where('KDDOKTER', @${$row['ppa']})->first();
                            if($dokter && $dokter->NAMADOKTER){
                                
                                $nama_dokter = $dokter->NAMADOKTER;
                                $kode_dokter = @${$row['ppa']};
                                if($row['sumber'] == "HARGA"){
                                    if($row['value'] > 1 ){
                                        $nilai_remunerasi = $row['value'];
                                    }else{
                                        $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                                    }
                                    
                                }else{
                                    
                                    $nilai_remunerasi = $data_sumber[$row['sumber']]*$row['value'];
                                }

                            }else{
                                $nama_dokter = "";
                                $kode_dokter = 0;
                                $nilai_remunerasi = 0;
                            
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
                            'cluster'=>(@$kode_dokter == 127)?2:1,
                            'idxdaftar'=>$idxdaftar,
                            'nomr'=>$nomr,
                            'tanggal'=>$data_detail_source->tgl_verifikasi,
                            'nama_ppa'=>$nama_dokter,
                            'kode_dokter'=>@$kode_dokter,
                            'sumber_value'=>$data_sumber[$row['sumber']],
                            'nilai_remunerasi'=>$nilai_remunerasi
                        ];               
                        $savePembagianKlaim = PembagianKlaim::create($data);
                    }
                }
              
            
              
                if($savePembagianKlaim){
                    $detailSource->update([
                        'status_pembagian_klaim'=>1,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr
                    ]);
                }
                
            }else{
                echo "Jenis tidak diketahui";
                die;
            }
           
        }
    
      return response()->json([
        'success' => true,
        'message' => 'Success',
        'data' => [
            "grade" => $grade,
            "jenis" => $jenis,
            "pisau" => $pisau
        ]
      ]);
    }
    public function listAdmission(Request $request)
    {
        if ($request->ajax()) {
            $data = Tadmission::with(['pasien','billranap','billrajal']);
            
            // Default filter untuk bulan dan tahun sekarang
            $bulan = $request->get('bulan', date('n')); 
            $tahun = $request->get('tahun', date('Y')); 
            
            if ($bulan && $tahun) {
                $data->whereMonth('keluarrs', $bulan)
                     ->whereYear('keluarrs', $tahun);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_tarif_rs', function ($row) {
                    return number_format($row->total_tarif_rs, 0, ',', '.');
                })
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="admission-checkbox" value="'.$row->id_admission.'">';
                })
               
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admission.list');
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
        
        $tbpjs = Tbpjs::where('sep', $sep)->first();
        if($tbpjs){
            $idxdaftar = $tbpjs->idxdaftar;
             $nomr = $tbpjs->noMr;
            if($nomr == ""){
                $response = $tbpjs->response;
                $nomr = $this->ambilNoMR($response);
            }
            if($nomr == ""){
                $datasep = $this->getApi("http://192.168.10.5/bpjs_2/cari_pasien/cari_idx2.php?q=".$sep);
                $data = json_decode($datasep);
                $idxdaftar = $data->data->idxdaftar;
                $nomr = $data->data->nomr;
            }
        
            
           
        }else{
            $datasep = $this->getApi("http://192.168.10.5/bpjs_2/cari_pasien/cari_idx2.php?q=".$sep);
            $data = json_decode($datasep);
            $idxdaftar = $data->data->idxdaftar;
            $nomr = $data->data->nomr;
           
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
            $data = PembagianKlaim::findOrFail($id);
            return ResponseFormatter::success($data, 'Data berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan');
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

    public function showDetail($id)
    {
        // Get admission data
        $admission = DB::connection('simrs')
            ->table('t_admission as a')
            ->leftJoin('m_pasien as b', 'b.NOMR', '=', 'a.nomr')
            ->where('a.id_admission', $id)
            ->select('a.*', 'b.NAMA as nama_pasien')
            ->first();

        // Get ranap billing data
        $ranapData = DB::connection('simrs')
            ->table('t_billranap as f')
            ->leftJoin('m_tarif2012 as g', 'g.kode_tindakan', '=', 'f.KODETARIF')
            ->leftJoin('m_dokter as h', 'h.KDDOKTER', '=', 'f.KDDOKTER')
            ->leftJoin('m_carabayar as i', 'i.KODE', '=', 'f.CARABAYAR')
            ->where('f.IDXDAFTAR', $id)
            ->where('f.status', '<>', 'BATAL')
            ->select(
                'f.UNIT',
                'f.KODETARIF',
                'g.nama_tindakan',
                'h.NAMADOKTER',
                'i.nama as CARABAYAR',
                'f.QTY',
                'f.TARIFRS',
                DB::raw('f.QTY * f.TARIFRS as TOTAL'),
                'f.TANGGAL'
            )
            ->get();

        // Get rajal billing data
        $rajalData = DB::connection('simrs')
            ->table('t_billrajal as f')
            ->leftJoin('m_tarif2012 as g', 'g.kode_tindakan', '=', 'f.KODETARIF')
            ->leftJoin('m_dokter as h', 'h.KDDOKTER', '=', 'f.KDDOKTER')
            ->leftJoin('m_carabayar as i', 'i.KODE', '=', 'f.CARABAYAR')
            ->where('f.IDXDAFTAR', $id)
            ->where('f.status', '<>', 'BATAL')
            ->select(
                'f.UNIT',
                'f.KODETARIF',
                'g.nama_tindakan',
                'h.NAMADOKTER',
                'i.nama as CARABAYAR',
                'f.QTY',
                'f.TARIFRS',
                DB::raw('f.QTY * f.TARIFRS as TOTAL'),
                'f.TANGGAL'
            )
            ->get();

        // Format data billing
        $formattedRanapData = $this->formatBillingData($ranapData);
        $formattedRajalData = $this->formatBillingData($rajalData);

        return view('admission.detail', [
            'admission' => $admission,
            'ranapData' => $formattedRanapData,
            'rajalData' => $formattedRajalData
        ]);
    }
} 