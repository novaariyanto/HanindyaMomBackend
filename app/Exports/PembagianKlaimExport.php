<?php

namespace App\Exports;

use App\Models\PembagianKlaim;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class PembagianKlaimExport
{
    protected $sourceId;
    protected $filters;

    public function __construct($sourceId, $filters = [])
    {
        $this->sourceId = $sourceId;
        $this->filters = $filters;
    }

    public function export()
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set worksheet title
        $sheet->setTitle('Data Pembagian Klaim');

        // Get data with filters
        $data = $this->getData();

        // Set headers
        $headers = [
            'A1' => 'No',
            'B1' => 'Sep',
            'C1' => 'PPA',
            'D1' => 'Sumber',
            'E1' => 'Cluster',
            'F1' => 'Jenis PPA',
            'G1' => 'Grade',
            'H1' => 'Jenis',
            'I1' => 'Group',
            'J1' => 'Nilai Remunerasi',
            'K1' => 'Tanggal',
            'L1' => 'No. MR',
            'M1' => 'IDX Daftar'
        ];

        // Set header values
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header
        $headerRange = 'A1:M1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2EFDA']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Fill data
        $row = 2;
        $counter = 1;
        
        // Jika tidak ada data, tambahkan baris kosong dengan keterangan
        if ($data->count() === 0) {
            $sheet->setCellValue('A2', 'Tidak ada data yang sesuai dengan filter');
            $sheet->mergeCells('A2:M2');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $row = 3;
        }
        
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $counter++);
            $sheet->setCellValue('B' . $row, $item->sep);
            $sheet->setCellValue('C' . $row, $item->nama_ppa);
            $sheet->setCellValue('D' . $row, $item->sumber);
            $sheet->setCellValue('E' . $row, $this->getClusterName($item->cluster));
            $sheet->setCellValue('F' . $row, $item->ppa);
            $sheet->setCellValue('G' . $row, $item->grade);
            $sheet->setCellValue('H' . $row, $item->jenis);
            $sheet->setCellValue('I' . $row, $item->groups);
            // Gunakan nilai_remunerasi atau fallback ke value seperti di controller
            $nilaiRemunerasi = $item->nilai_remunerasi ?: $item->value ?: 0;
            $sheet->setCellValue('J' . $row, $nilaiRemunerasi);
            $sheet->setCellValue('K' . $row, $item->tanggal ? Carbon::parse($item->tanggal)->format('d/m/Y') : '');
            $sheet->setCellValue('L' . $row, $item->nomr);
            $sheet->setCellValue('M' . $row, $item->idxdaftar);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'M') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Style data rows
        if ($row > 2) {
            $dataRange = 'A2:M' . ($row - 1);
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ]);

            // Format nilai remunerasi column (J)
            $sheet->getStyle('J2:J' . ($row - 1))->getNumberFormat()
                ->setFormatCode('#,##0.00');

            // Align number columns to right
            $sheet->getStyle('A2:A' . ($row - 1))->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J2:J' . ($row - 1))->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('L2:M' . ($row - 1))->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Create writer and return spreadsheet
        return $spreadsheet;
    }

    public function getData()
    {
        $query = PembagianKlaim::query()
            ->where('remunerasi_source_id', $this->sourceId)
            ->where('del', false);

        // Apply filters - menggunakan pattern yang sama seperti di controller
        if (!empty($this->filters['filter_nama_ppa'])) {
            $query->where('nama_ppa', 'like', '%' . $this->filters['filter_nama_ppa'] . '%');
        }

        if (!empty($this->filters['filter_sumber'])) {
            $query->where('sumber', 'like', '%' . $this->filters['filter_sumber'] . '%');
        }

        if (!empty($this->filters['filter_cluster'])) {
            $query->where('cluster', $this->filters['filter_cluster']);
        }

        if (!empty($this->filters['filter_ppa'])) {
            $query->where('ppa', 'like', '%' . $this->filters['filter_ppa'] . '%');
        }

        if (!empty($this->filters['filter_grade'])) {
            $query->where('grade', 'like', '%' . $this->filters['filter_grade'] . '%');
        }

        if (!empty($this->filters['filter_jenis'])) {
            $query->where('jenis', 'like', '%' . $this->filters['filter_jenis'] . '%');
        }

        if (!empty($this->filters['filter_group'])) {
            $query->where('groups', 'like', '%' . $this->filters['filter_group'] . '%');
        }

        $data = $query->orderBy('sep')->get();
        
        // Debug: log jumlah data yang ditemukan
        \Log::info('Export Data Count: ' . $data->count());
        \Log::info('Source ID: ' . $this->sourceId);
        \Log::info('Filters: ' . json_encode($this->filters));
        \Log::info('SQL Query: ' . $query->toSql());
        
        // Jika tidak ada data, cek total data tanpa filter
        if ($data->count() === 0) {
            $totalData = PembagianKlaim::where('remunerasi_source_id', $this->sourceId)->where('del', false)->count();
            \Log::info('Total data without filters: ' . $totalData);
        }
        
        return $data;
    }

    private function getClusterName($cluster)
    {
        return match($cluster) {
            1 => 'Dokter',
            2 => 'Perawat',
            3 => 'Penunjang',
            4 => 'Administrasi',
            default => 'Tidak Diketahui'
        };
    }
} 