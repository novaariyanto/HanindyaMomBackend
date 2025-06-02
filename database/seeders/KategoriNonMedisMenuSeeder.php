<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Str;

class KategoriNonMedisMenuSeeder extends Seeder
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

        // Menu Kategori Non Medis
        $existingMenu = Menu::where('nama_menu', 'Kategori Non Medis')->first();
        
        if (!$existingMenu) {
            Menu::create([
                'uuid' => (string) Str::uuid(),
                'nama_menu' => 'Kategori Non Medis',
                'route' => 'kategori-non-medis.index',
                'icon' => 'ti ti-category',
                'parent_id' => $parentMenu->id,
                'order' => 5
            ]);
            
            $this->command->info('Menu Kategori Non Medis berhasil ditambahkan');
        } else {
            $this->command->info('Menu Kategori Non Medis sudah ada');
        }
    }
} 