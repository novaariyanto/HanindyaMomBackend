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

class PendaftaranController extends Controller
{
    /**
     * Menampilkan daftar pembagian klaim.
     */
    
    public function listPendaftaran(Request $request)
    {
        if ($request->ajax()) {
            $data = Tpendaftaran::with(['pasien','billrajal']);
                
            
            $bulan = $request->get('bulan', date('n')); 
            $tahun = $request->get('tahun', date('Y')); 
            $penjamin = $request->get('penjamin');

            if ($bulan && $tahun) {
                $data->whereMonth('TGLREG', $bulan)
                     ->whereYear('TGLREG', $tahun);
            }
            if($penjamin == 1){
                $data->whereIn('kdcarabayar', [10, 20]);
            }elseif($penjamin == 2){
                $data->whereNotIn('kdcarabayar', [10, 20]);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_tarif_rs', function ($row) {
                    return number_format($row->total_tarif_rs, 0, ',', '.');
                })
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="admission-checkbox" value="'.$row->IDXDAFTAR.'">';
                })
                ->addColumn('jenis', function($row) {
                    return 'Rawat Jalan';
                })
                ->addColumn('status', function($row) {
                    return 'Aktif';
                })
                ->addColumn('biaya_diajukan', function($row) {
                    return number_format($row->total_tarif_rs, 0, ',', '.');
                })
                ->addColumn('biaya_disetujui', function($row) {
                    return number_format($row->total_tarif_rs, 0, ',', '.');
                })
                ->addColumn('biaya_riil_rs', function($row) {
                    return number_format($row->total_tarif_rs, 0, ',', '.');
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.route('pendaftaran.detail', $row->IDXDAFTAR).'" class="btn btn-primary">Detail</a>';
                })
               
                ->make(true);
        }

        return view('pendaftaran.list');
    }

   
    public function exportExcel(Request $request)
    {
        // Ambil data admission dengan relasi
        $data = Tpendaftaran::with(['pasien', 'billrajal'])
            ->whereMonth('TGLREG', $request->get('bulan', date('n')))
            ->whereYear('TGLREG', $request->get('tahun', date('Y')))
            ->when($request->get('penjamin') == 1, function ($query) {
                $query->whereIn('kdcarabayar', [10, 20]);
            })
            ->when($request->get('penjamin') == 2, function ($query) {
                $query->whereNotIn('kdcarabayar', [10, 20]);
            })
            ->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No SEP');
        $sheet->setCellValue('B1', 'Tanggal Verifikasi');
        $sheet->setCellValue('C1', 'Biaya Riil RS');
        $sheet->setCellValue('D1', 'Biaya Diajukan');
        $sheet->setCellValue('E1', 'Biaya Disetujui');
        $sheet->setCellValue('F1', 'Status');
        $sheet->setCellValue('G1', 'Jenis');
        $sheet->setCellValue('H1', 'Idxdaftar');

        // Isi data
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->NOMR);
            $sheet->setCellValue('B' . $row, $item->TGLREG ? date('d-m-Y', strtotime($item->TGLREG)) : '');
            $sheet->setCellValue('C' . $row, $item->total_tarif_rs);
            $sheet->setCellValue('D' . $row, $item->total_tarif_rs);
            $sheet->setCellValue('E' . $row, $item->total_tarif_rs);
            $sheet->setCellValue('F' . $row, 'Aktif');
            $sheet->setCellValue('G' . $row, 'Rawat Jalan');
            $sheet->setCellValue('H' . $row, $item->IDXDAFTAR);
            $row++;
        }

        // Auto size kolom
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Format angka untuk kolom nominal (Biaya)
        foreach (range('C', 'E') as $column) {
            for ($i = 2; $i <= $row - 1; $i++) {
                $sheet->getStyle($column . $i)->getNumberFormat()
                    ->setFormatCode('#,##0');
            }
        }

        // Set style header
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFCCCCCC');

        // Set border untuk semua cell yang berisi data
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A1:H' . ($row - 1))->applyFromArray($styleArray);

        // Buat file Excel
        $filename = 'Data_Rawat_Jalan_' . date('Y-m') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
    public function showDetail($id)
    {
        // Get pendaftaran data with relations
        $pendaftaran = Tpendaftaran::with(['pasien'])
            ->where('IDXDAFTAR', $id)
            ->first();

        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan');
        }

        // Get billing data
        $billData = DB::connection('simrs')
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
                'f.TANGGAL',
                DB::raw('"rajal" as source')
            )
            ->get();

        // Format billing data
        $formattedData = $this->formatBillingData($billData);

        return view('pendaftaran.detail', [
            'pendaftaran' => $pendaftaran,
            'billData' => $formattedData,
            'totalTarifRs' => $pendaftaran->total_tarif_rs
        ]);
    }
    private function formatBillingData($data)
    {
        if ($data->isEmpty()) {
            return [];
        }

        $result = [
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

        $totalKeseluruhan = 0;

        foreach ($data as $item) {
            $unitKey = $this->getUnitKey($item->UNIT);
            if ($unitKey) {
                $result[$unitKey]['data'][] = $item;
                $result[$unitKey]['total'] += $item->TOTAL;
                $totalKeseluruhan += $item->TOTAL;
            }
        }

        return [
            'units' => $result,
            'total_keseluruhan' => $totalKeseluruhan
        ];
    }

    private function getUnitKey($unitCode)
    {
        $unitMap = [
            19 => 'ruang',
            16 => 'laboratorium',
            17 => 'radiologi',
            15 => 'kamar_operasi',
            14 => 'farmasi'
        ];

        return $unitMap[$unitCode] ?? null;
    }
} 