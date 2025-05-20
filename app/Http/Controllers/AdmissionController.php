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

class AdmissionController extends Controller
{
    /**
     * Menampilkan daftar pembagian klaim.
     */
    
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
                ->addColumn('jenis', function($row) {
                    return 'Rawat Inap';
                })
                ->addColumn('status', function($row) {
                    return 'Aktif';
                })
                ->addColumn('biaya_diajukan', function($row) {
                    return number_format($row->biaya_diajukan, 0, ',', '.');
                })
                ->addColumn('biaya_disetujui', function($row) {
                    return number_format($row->biaya_disetujui, 0, ',', '.');
                })
                ->addColumn('biaya_riil_rs', function($row) {
                    return number_format($row->biaya_riil_rs, 0, ',', '.');
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.route('admission.detail', $row->id_admission).'" class="btn btn-primary">Detail</a>';
                })
               
                ->make(true);
        }

        return view('admission.list');
    }

    public function exportExcel(Request $request)
    {
        // Ambil data admission dengan relasi
        $data = Tadmission::with(['pasien', 'billranap', 'billrajal'])
            ->whereMonth('keluarrs', $request->get('bulan', date('n')))
            ->whereYear('keluarrs', $request->get('tahun', date('Y')))
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

        // Isi data
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->nosep);
            $sheet->setCellValue('B' . $row, $item->keluarrs ? date('d-m-Y', strtotime($item->keluarrs)) : '');
            $sheet->setCellValue('C' . $row, $item->biaya_riil_rs);
            $sheet->setCellValue('D' . $row, $item->biaya_diajukan);
            $sheet->setCellValue('E' . $row, $item->biaya_disetujui);
            $sheet->setCellValue('F' . $row, 'Aktif');
            $sheet->setCellValue('G' . $row, 'Rawat Inap');
            $row++;
        }

        // Auto size kolom
        foreach (range('A', 'G') as $column) {
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
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()
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
        $sheet->getStyle('A1:G' . ($row - 1))->applyFromArray($styleArray);

        // Buat file Excel
        $filename = 'Data_Admission_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
} 