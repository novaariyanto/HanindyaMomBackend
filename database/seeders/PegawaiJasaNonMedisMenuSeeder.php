<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Str;

class PegawaiJasaNonMedisMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari atau buat parent menu untuk Master Data
        $parentMenu = Menu::where('nama_menu', 'Master Data')->first();
        
        if (!$parentMenu) {
            $parentMenu = Menu::create([
                'uuid' => (string) Str::uuid(),
                'nama_menu' => 'Master Data',
                'route' => '#',
                'icon' => 'ti ti-list',
                'parent_id' => null,
                'order' => 2
            ]);
            
            $this->command->info('Parent menu Master Data berhasil ditambahkan');
        }

        // Menu Pegawai Jasa Non Medis
        $existingMenu = Menu::where('nama_menu', 'Pegawai Jasa Non Medis')->first();
        
        if (!$existingMenu) {
            Menu::create([
                'uuid' => (string) Str::uuid(),
                'nama_menu' => 'Pegawai Jasa Non Medis',
                'route' => 'pegawai-jasa-non-medis.index',
                'icon' => 'ti ti-users-group',
                'parent_id' => $parentMenu->id,
                'order' => 6
            ]);
            
            $this->command->info('Menu Pegawai Jasa Non Medis berhasil ditambahkan');
        } else {
            $this->command->info('Menu Pegawai Jasa Non Medis sudah ada');
        }
    }
} 