<?php

namespace App\Exports;

use App\Models\JtlPegawaiHasil;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JtlPegawaiHasilExport
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function export()
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Sistem Remunerasi')
            ->setTitle('Data JTL Pegawai Hasil')
            ->setSubject('Export Data JTL Pegawai Hasil')
            ->setDescription('Export data JTL Pegawai Hasil dari sistem remunerasi');

        // Define headers
        $headers = [
            'A1' => 'No',
            'B1' => 'NIK',
            'C1' => 'Nama Pegawai',
            'D1' => 'Unit Kerja',
            'E1' => 'Remunerasi Source',
            'F1' => 'Dasar',
            'G1' => 'Kompetensi',
            'H1' => 'Resiko',
            'I1' => 'Emergensi',
            'J1' => 'Posisi',
            'K1' => 'Kinerja',
            'L1' => 'Jumlah',
            'M1' => 'Nilai Indeks',
            'N1' => 'JTL Bruto',
            'O1' => 'Pajak (%)',
            'P1' => 'Potongan Pajak',
            'Q1' => 'JTL Net',
            'R1' => 'Rekening'
        ];

        // Set headers
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header row
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
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
        ];

        $sheet->getStyle('A1:R1')->applyFromArray($headerStyle);

        // Get data based on filters
        $query = JtlPegawaiHasil::with(['pegawai', 'remunerasiSource']);

        // Apply filters
        if (!empty($this->filters['remunerasi_source_id'])) {
            $query->where('remunerasi_source', $this->filters['remunerasi_source_id']);
        }

        if (!empty($this->filters['unit_kerja'])) {
            $query->where('unit_kerja', $this->filters['unit_kerja']);
        }

        if (!empty($this->filters['search'])) {
            $query->where(function($q) {
                $q->where('nik', 'like', '%' . $this->filters['search'] . '%')
                  ->orWhere('nama_pegawai', 'like', '%' . $this->filters['search'] . '%');
            });
        }

        $data = $query->orderBy('nama_pegawai')->get();

        // Fill data rows
        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, "'".$item->nik);
            $sheet->setCellValue('C' . $row, $item->nama_pegawai);
            $sheet->setCellValue('D' . $row, $item->unit_kerja);
            $sheet->setCellValue('E' . $row, $item->remunerasiSource ? $item->remunerasiSource->nama_source : '-');
            $sheet->setCellValue('F' . $row, $item->dasar);
            $sheet->setCellValue('G' . $row, $item->kompetensi);
            $sheet->setCellValue('H' . $row, $item->resiko);
            $sheet->setCellValue('I' . $row, $item->emergensi);
            $sheet->setCellValue('J' . $row, $item->posisi);
            $sheet->setCellValue('K' . $row, $item->kinerja);
            $sheet->setCellValue('L' . $row, $item->jumlah);
            $sheet->setCellValue('M' . $row, $item->nilai_indeks);
            $sheet->setCellValue('N' . $row, $item->jtl_bruto);
            $sheet->setCellValue('O' . $row, $item->pajak);
            $sheet->setCellValue('P' . $row, $item->potongan_pajak);
            $sheet->setCellValue('Q' . $row, $item->jtl_net);
            $sheet->setCellValue('R' . $row, $item->rekening ?: '-');

            $row++;
            $no++;
        }

        // Style data rows
        $dataRange = 'A2:R' . ($row - 1);
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];

        if ($row > 2) {
            $sheet->getStyle($dataRange)->applyFromArray($dataStyle);

            // Format number columns
            $sheet->getStyle('F2:M' . ($row - 1))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            $sheet->getStyle('N2:N' . ($row - 1))->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
            $sheet->getStyle('O2:O' . ($row - 1))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);
            $sheet->getStyle('P2:Q' . ($row - 1))->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

            // Center align number columns
            $sheet->getStyle('A2:A' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F2:Q' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Apply zebra striping
            for ($i = 2; $i < $row; $i++) {
                if ($i % 2 == 0) {
                    $sheet->getStyle('A' . $i . ':R' . $i)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('F8F9FA');
                }
            }
        }

        // Auto-size columns
        foreach (range('A', 'R') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set minimum width for some columns
        $sheet->getColumnDimension('C')->setWidth(25); // Nama Pegawai
        $sheet->getColumnDimension('D')->setWidth(20); // Unit Kerja
        $sheet->getColumnDimension('E')->setWidth(25); // Remunerasi Source

        // Freeze header row
        $sheet->freezePane('A2');

        // Set sheet title
        $sheet->setTitle('JTL Pegawai Hasil');

        return $spreadsheet;
    }

    public function download()
    {
        $spreadsheet = $this->export();
        $filename = 'jtl_pegawai_hasil_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Create a StreamedResponse
        return new StreamedResponse(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
} 