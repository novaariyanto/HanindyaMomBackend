<?php

namespace App\Exports;

use App\Models\Jtldata;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class JtldataExport
{
    protected $id_remunerasi_source;

    public function __construct($id_remunerasi_source = null)
    {
        $this->id_remunerasi_source = $id_remunerasi_source;
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator("Sistem Remunerasi")
            ->setLastModifiedBy("Sistem Remunerasi")
            ->setTitle("Data JTL Export")
            ->setSubject("Data JTL")
            ->setDescription("Export data JTL dari sistem remunerasi");

        // Set headers
        $headers = [
            'No',
            'Remunerasi Source',
            'Nama Pembagian',
            'Nilai',
            'Jumlah Indeks',
            'Nilai Indeks',
            'Dibagi All Pegawai',
            'Tanggal Dibuat'
        ];

        // Set header row
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        // Style header row
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ]
            ]
        ];

        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Get data
        $query = Jtldata::with('remunerasiSource');
        
        if ($this->id_remunerasi_source) {
            $query->where('id_remunerasi_source', $this->id_remunerasi_source);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();

        // Fill data
        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $item->remunerasiSource ? $item->remunerasiSource->nama_source : '-');
            $sheet->setCellValue('C' . $row, $item->nama_pembagian ?? '-');
            
            // Set numeric values as numbers, not formatted strings
            $sheet->setCellValue('D' . $row, (float) $item->jumlah_jtl);
            $sheet->setCellValue('E' . $row, (float) $item->jumlah_indeks);
            $sheet->setCellValue('F' . $row, (float) $item->nilai_indeks);
            
            $sheet->setCellValue('G' . $row, $item->allpegawai == 1 ? 'Ya' : 'Tidak');
            $sheet->setCellValue('H' . $row, $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-');

            $no++;
            $row++;
        }

        // Style data rows
        $dataStyle = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ]
            ]
        ];

        if ($row > 2) {
            $sheet->getStyle('A2:H' . ($row - 1))->applyFromArray($dataStyle);

            // Style number columns
            $sheet->getStyle('A2:A' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D2:F' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('G2:G' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Format number columns
            $sheet->getStyle('D2:E' . ($row - 1))->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('F2:F' . ($row - 1))->getNumberFormat()->setFormatCode('_("Rp"* #,##0.00_);_("Rp"* \(#,##0.00\);_("Rp"* "-"??_);_(@_)');
        }

        // Auto size columns
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set minimum width for some columns
        $sheet->getColumnDimension('B')->setWidth(25); // Remunerasi Source
        $sheet->getColumnDimension('C')->setWidth(20); // Nama Pembagian
        $sheet->getColumnDimension('H')->setWidth(18); // Tanggal

        return $spreadsheet;
    }
} 