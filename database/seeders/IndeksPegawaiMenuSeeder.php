<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Str;

class IndeksPegawaiMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah menu sudah ada
        $existingMenu = Menu::where('nama_menu', 'Indeks Pegawai')->first();
        
        if (!$existingMenu) {
            Menu::create([
                'uuid' => (string) Str::uuid(),
                'nama_menu' => 'Indeks Pegawai',
                'route' => 'indeks-pegawai.index',
                'icon' => 'ti ti-id-badge',
                'parent_id' => null,
                'order' => 999  // Letakkan di akhir
            ]);
            
            $this->command->info('Menu Indeks Pegawai berhasil ditambahkan');
        } else {
            $this->command->info('Menu Indeks Pegawai sudah ada');
        }
    }
}
