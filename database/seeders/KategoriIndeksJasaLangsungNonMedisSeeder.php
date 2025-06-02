<?php

namespace Database\Seeders;

use App\Models\KategoriIndeksJasaLangsungNonMedis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriIndeksJasaLangsungNonMedisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'Administrasi',
                'deskripsi' => 'Kategori untuk jasa administrasi dan tata usaha',
                'status' => true
            ],
            [
                'nama_kategori' => 'Kebersihan',
                'deskripsi' => 'Kategori untuk jasa kebersihan dan sanitasi',
                'status' => true
            ],
            [
                'nama_kategori' => 'Keamanan',
                'deskripsi' => 'Kategori untuk jasa keamanan dan pengamanan',
                'status' => true
            ],
            [
                'nama_kategori' => 'Maintenance',
                'deskripsi' => 'Kategori untuk jasa pemeliharaan dan perbaikan',
                'status' => true
            ],
            [
                'nama_kategori' => 'Pelayanan Umum',
                'deskripsi' => 'Kategori untuk jasa pelayanan umum',
                'status' => true
            ],
            [
                'nama_kategori' => 'Transportasi',
                'deskripsi' => 'Kategori untuk jasa transportasi dan pengangkutan',
                'status' => true
            ],
            [
                'nama_kategori' => 'Catering',
                'deskripsi' => 'Kategori untuk jasa makanan dan minuman',
                'status' => true
            ],
            [
                'nama_kategori' => 'Lainnya',
                'deskripsi' => 'Kategori untuk jasa lainnya yang tidak termasuk kategori di atas',
                'status' => true
            ]
        ];

        foreach ($kategori as $item) {
            KategoriIndeksJasaLangsungNonMedis::create($item);
        }
    }
}
