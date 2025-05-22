<?php

namespace App\Imports;

use App\Models\DetailSource;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class DetailSourceImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $sourceId;

    public function __construct($sourceId)
    {
        $this->sourceId = $sourceId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new DetailSource([
            'id_remunerasi_source' => $this->sourceId,
            'no_sep' => $row['no_sep'],
            'tgl_verifikasi' => $this->transformDate($row['tgl_verifikasi']),
            'jenis' => $row['jenis'],
            'biaya_riil_rs' => $this->transformToDecimal($row['biaya_riil_rs']),
            'biaya_diajukan' => $this->transformToDecimal($row['biaya_diajukan']),
            'biaya_disetujui' => $this->transformToDecimal($row['biaya_disetujui']),
            'status' => $row['status'] == 'Aktif' ? 1 : 0,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'no_sep' => 'required|string|max:30|unique:detail_source,no_sep',
            'tgl_verifikasi' => 'required',
            'jenis' => 'required|string|max:50',
            'biaya_riil_rs' => 'required',
            'biaya_diajukan' => 'required',
            'biaya_disetujui' => 'required',
            'status' => 'required|in:Aktif,Nonaktif',
        ];
    }

    /**
     * Transform date value from Excel
     */
    private function transformDate($value)
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\Exception $e) {
            return Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    /**
     * Transform decimal value from Excel
     */
    private function transformToDecimal($value)
    {
        if (is_string($value)) {
            return (float) str_replace(['Rp', '.', ','], ['', '', '.'], $value);
        }
        return $value;
    }
} 