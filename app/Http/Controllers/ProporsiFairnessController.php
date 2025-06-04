<?php

namespace App\Http\Controllers;

use App\Models\ProporsiFairness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;
use App\Models\Grade;
use App\Models\Sumber;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProporsiFairnessController extends Controller
{
    /**
     * Menampilkan daftar proporsi fairness.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProporsiFairness::where('del', false);
            
            // Filter by grade
            if ($request->has('grade') && $request->grade != '') {
                $data->where('grade', $request->grade);
            }
            
            // Filter by sumber
            if ($request->has('sumber') && $request->sumber != '') {
                $data->where('sumber', $request->sumber);
            }

            // Filter by jenis
            if ($request->has('jenis') && $request->jenis != '') {
                $data->where('jenis', $request->jenis);
            }

             // Filter by sumber
             if ($request->has('groups') && $request->groups != '') {
                $data->where('groups', $request->groups);
            }
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('proporsi-fairness.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('proporsi-fairness.destroy', $row->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Data untuk filter dan select option
        $grades = Grade::all();
        $sumbers = Sumber::all();

        return view('proporsi-fairness.index', [
            'title' => 'Proporsi Fairness',
            'grades' => $grades,
            'sumbers' => $sumbers
        ]);
    }

    /**
     * Menyimpan proporsi fairness baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'groups' => 'required|string|max:50',
            'jenis' => 'required|string|max:50',
            'grade' => 'required|string|max:50',
            'ppa' => 'required|string|max:50',
            'value' => 'required|numeric|between:0,99999999.99',
            'sumber' => 'required|string|max:100',
            'flag' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $proporsi = ProporsiFairness::create($request->all());
            return ResponseFormatter::success($proporsi, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menyimpan data', 500);
        }
    }

    /**
     * Menampilkan proporsi fairness spesifik.
     */
    public function show($id)
    {
        try {
            $proporsi = ProporsiFairness::findOrFail($id);
            
            if ($proporsi->del) {
                return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
            }

            return ResponseFormatter::success($proporsi, 'Data berhasil ditemukan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }
    }

    /**
     * Mengupdate proporsi fairness yang ada.
     */
    public function update(Request $request, $id)
    {
        try {
            $proporsi = ProporsiFairness::findOrFail($id);

            if ($proporsi->del) {
                return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
            }

            $validator = Validator::make($request->all(), [
                'groups' => 'required|string|max:50',
                'jenis' => 'required|string|max:50',
                'grade' => 'required|string|max:50',
                'ppa' => 'required|string|max:50',
                'value' => 'required|numeric|between:0,99999999.99',
                'sumber' => 'required|string|max:100',
                'flag' => 'required|string|max:50'
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
            }

            $proporsi->update($request->all());
            return ResponseFormatter::success($proporsi, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengupdate data', 500);
        }
    }

    /**
     * Soft delete proporsi fairness.
     */
    public function destroy($id)
    {
        $proporsi = ProporsiFairness::find($id);

        if (!$proporsi || $proporsi->del) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        try {
            $proporsi->update(['del' => true]);
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menghapus data', 500);
        }
    }

    public function downloadTemplate()
    {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set judul worksheet
            $sheet->setTitle('Template Proporsi Fairness');

            // Set header kolom
            $headers = [
                'A1' => 'Groups',
                'B1' => 'Jenis',
                'C1' => 'Grade',
                'D1' => 'PPA',
                'E1' => 'Value',
                'F1' => 'Sumber',
                'G1' => 'Flag'
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Set contoh data
            $exampleData = [
                'A2' => 'RJTL',
                'B2' => 'Pisau',
                'C2' => 'Grade 1',
                'D2' => 'PPA 1',
                'E2' => '100.00',
                'F2' => 'Sumber 1',
                'G2' => 'Flag 1'
            ];

            foreach ($exampleData as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Set style header
            $sheet->getStyle('A1:G1')->getFont()->setBold(true);
            $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('E2E2E2');
            
            // Set lebar kolom otomatis
            foreach(range('A','G') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            // Tambahkan validasi data untuk kolom Groups
            $validation = $sheet->getCell('A2')->getDataValidation();
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"RJTL,RITL"');
            
            // Tambahkan validasi data untuk kolom Jenis
            $validation = $sheet->getCell('B2')->getDataValidation();
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"Pisau,NONPISAU"');

            // Set format angka untuk kolom Value
            $sheet->getStyle('E2')->getNumberFormat()->setFormatCode('#,##0.00');

            // Buat writer untuk output
            $writer = new Xlsx($spreadsheet);

            // Set header untuk download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="template_proporsi_fairness.xlsx"');
            header('Cache-Control: max-age=0');

            // Simpan file ke output
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal mengunduh template: ' . $e->getMessage(), 500);
        }
    }

    public function import(Request $request)
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
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            // Remove header
            array_shift($rows);
            
            $success = 0;
            $failed = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Validate data
                $rowData = [
                    'groups' => $row[0],
                    'jenis' => $row[1],
                    'grade' => $row[2],
                    'ppa' => $row[3],
                    'value' => (float)$row[4],
                    'sumber' => $row[5],
                    'flag' => $row[6]
                ];

                $rowValidator = Validator::make($rowData, [
                    'groups' => 'required|string|max:50',
                    'jenis' => 'required|string|max:50',
                    'grade' => 'required|string|max:50',
                    'ppa' => 'required|string|max:50',
                    'value' => 'required|numeric|between:0,99999999.99',
                    'sumber' => 'required|string|max:100',
                    'flag' => 'required|string|max:50'
                ]);

                if ($rowValidator->fails()) {
                    $failed++;
                    $errors[] = json_encode($rowData)."Baris " . ($index + 2) . ": " . implode(', ', $rowValidator->errors()->all());
                    continue;
                }

                try {
                    ProporsiFairness::create($rowData);
                    $success++;
                } catch (\Exception $e) {
                    $failed++;
                    $errors[] = "Baris " . ($index + 2) . ": Gagal menyimpan data";
                }
            }

            $message = "Berhasil import $success data";
            if ($failed > 0) {
                $message .= ", Gagal import $failed data";
            }

            return ResponseFormatter::success([
                'success' => $success,
                'failed' => $failed,
                'errors' => $errors
            ], $message);

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal memproses file: ' . $e->getMessage(), 500);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            // Query data
            $query = ProporsiFairness::with(['gradeRelation', 'sumberRelation'])
                ->where('del', false);
            
            // Filter by grade
            if ($request->has('grade') && $request->grade != '') {
                $query->where('grade', $request->grade);
            }
            
            // Filter by sumber
            if ($request->has('sumber') && $request->sumber != '') {
                $query->where('sumber', $request->sumber);
            }

            // Filter by jenis
            if ($request->has('jenis') && $request->jenis != '') {
                $query->where('jenis', $request->jenis);
            }

            // Filter by groups
            if ($request->has('groups') && $request->groups != '') {
                $query->where('groups', $request->groups);
            }

            $data = $query->get();

            // Buat spreadsheet baru
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set judul worksheet
            $sheet->setTitle('Data Proporsi Fairness');

            // Set header kolom
            $headers = [
                'A1' => 'No',
                'B1' => 'Groups',
                'C1' => 'Jenis',
                'D1' => 'Grade',
                'E1' => 'PPA',
                'F1' => 'Value',
                'G1' => 'Sumber',
                'H1' => 'Flag'
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Isi data
            $row = 2;
            foreach ($data as $index => $item) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $item->groups);
                $sheet->setCellValue('C' . $row, $item->jenis);
                $sheet->setCellValue('D' . $row, $item->grade);
                $sheet->setCellValue('E' . $row, $item->ppa);
                $sheet->setCellValue('F' . $row, $item->value);
                $sheet->setCellValue('G' . $row, $item->sumber);
                $sheet->setCellValue('H' . $row, $item->flag);
                $row++;
            }

            // Set style header
            $sheet->getStyle('A1:H1')->getFont()->setBold(true);
            $sheet->getStyle('A1:H1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E2E2E2');

            // Set lebar kolom otomatis
            foreach(range('A','H') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            // Set format angka untuk kolom Value
            $sheet->getStyle('F2:F' . ($row-1))->getNumberFormat()
                ->setFormatCode('#,##0.00');

            // Set border untuk semua cell yang berisi data
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $sheet->getStyle('A1:H' . ($row-1))->applyFromArray($styleArray);

            // Set alignment
            $sheet->getStyle('A1:H' . ($row-1))->getAlignment()
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:A' . ($row-1))->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F2:F' . ($row-1))->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

            // Buat file Excel
            $filename = 'Data_Proporsi_Fairness_' . date('Y-m-d_H-i-s') . '.xlsx';
            $writer = new Xlsx($spreadsheet);
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal mengekspor data: ' . $e->getMessage(), 500);
        }
    }

    public function export(Request $request)
    {
        try {
            // Query data dengan filter
            $query = ProporsiFairness::where('del', false);
            
            // Filter by grade
            if ($request->has('grade') && $request->grade != '') {
                $query->where('grade', $request->grade);
            }
            
            // Filter by sumber
            if ($request->has('sumber') && $request->sumber != '') {
                $query->where('sumber', $request->sumber);
            }

            // Filter by jenis
            if ($request->has('jenis') && $request->jenis != '') {
                $query->where('jenis', $request->jenis);
            }

            // Filter by groups
            if ($request->has('groups') && $request->groups != '') {
                $query->where('groups', $request->groups);
            }

            $data = $query->get();

            // Jika data kosong, kembalikan pesan error
            if ($data->isEmpty()) {
                return ResponseFormatter::error(null, 'Data tidak ditemukan untuk di-export', 404);
            }

            // Buat spreadsheet baru
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set judul worksheet
            $sheet->setTitle('Data Proporsi Fairness');

            // Set header kolom
            $headers = [
                'A1' => 'No',
                'B1' => 'Groups',
                'C1' => 'Jenis',
                'D1' => 'Grade',
                'E1' => 'PPA',
                'F1' => 'Value',
                'G1' => 'Sumber',
                'H1' => 'Flag'
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Isi data
            $row = 2;
            foreach ($data as $index => $item) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $item->groups);
                $sheet->setCellValue('C' . $row, $item->jenis);
                $sheet->setCellValue('D' . $row, $item->grade);
                $sheet->setCellValue('E' . $row, $item->ppa);
                $sheet->setCellValue('F' . $row, $item->value);
                $sheet->setCellValue('G' . $row, $item->sumber);
                $sheet->setCellValue('H' . $row, $item->flag);
                $row++;
            }

            // Set style header
            $sheet->getStyle('A1:H1')->getFont()->setBold(true);
            $sheet->getStyle('A1:H1')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E2E2E2');

            // Set lebar kolom otomatis
            foreach(range('A','H') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            // Set format angka untuk kolom Value
            $sheet->getStyle('F2:F' . ($row-1))->getNumberFormat()
                ->setFormatCode('#,##0.00');

            // Set border untuk semua cell yang berisi data
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $sheet->getStyle('A1:H' . ($row-1))->applyFromArray($styleArray);

            // Set alignment
            $sheet->getStyle('A1:H' . ($row-1))->getAlignment()
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:A' . ($row-1))->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F2:F' . ($row-1))->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

            // Buat file Excel
            $filename = 'Data_Proporsi_Fairness_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            // Set header untuk download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            // Simpan file ke output
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal mengekspor data: ' . $e->getMessage(), 500);
        }
    }
}
