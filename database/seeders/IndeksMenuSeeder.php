<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Str;

class IndeksMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari atau buat parent menu untuk Indeks
        $parentMenu = Menu::where('nama_menu', 'Indeks')->first();
        
        if (!$parentMenu) {
            $parentMenu = Menu::create([
                'uuid' => (string) Str::uuid(),
                'nama_menu' => 'Indeks',
                'route' => '#',
                'icon' => 'ti ti-chart-line',
                'parent_id' => null,
                'order' => 8  // Letakkan setelah menu yang sudah ada
            ]);
            
            $this->command->info('Parent menu Indeks berhasil ditambahkan');
        }

        // Menu Indeks Jasa Tidak Langsung
        $existingMenu1 = Menu::where('nama_menu', 'Indeks Jasa Tidak Langsung')->first();
        
        if (!$existingMenu1) {
            Menu::create([
                'uuid' => (string) Str::uuid(),
                'nama_menu' => 'Indeks Jasa Tidak Langsung',
                'route' => 'indeks-jasa-tidak-langsung.index',
                'icon' => 'ti ti-chart-dots',
                'parent_id' => $parentMenu->id,
                'order' => 1
            ]);
            
            $this->command->info('Menu Indeks Jasa Tidak Langsung berhasil ditambahkan');
        } else {
            $this->command->info('Menu Indeks Jasa Tidak Langsung sudah ada');
        }

        // Menu Indeks Jasa Langsung Non Medis
        $existingMenu2 = Menu::where('nama_menu', 'Indeks Jasa Langsung Non Medis')->first();
        
        if (!$existingMenu2) {
            Menu::create([
                'uuid' => (string) Str::uuid(),
                'nama_menu' => 'Indeks Jasa Langsung Non Medis',
                'route' => 'indeks-jasa-langsung-non-medis.index',
                'icon' => 'ti ti-chart-bar',
                'parent_id' => $parentMenu->id,
                'order' => 2
            ]);
            
            $this->command->info('Menu Indeks Jasa Langsung Non Medis berhasil ditambahkan');
        } else {
            $this->command->info('Menu Indeks Jasa Langsung Non Medis sudah ada');
        }

        // Menu Indeks Struktural jika belum ada
        $existingMenu3 = Menu::where('nama_menu', 'Indeks Struktural')->first();
        
        if (!$existingMenu3) {
            Menu::create([
                'uuid' => (string) Str::uuid(),
                'nama_menu' => 'Indeks Struktural',
                'route' => 'indeks-struktural.index',
                'icon' => 'ti ti-building-store',
                'parent_id' => $parentMenu->id,
                'order' => 3
            ]);
            
            $this->command->info('Menu Indeks Struktural berhasil ditambahkan');
        } else {
            $this->command->info('Menu Indeks Struktural sudah ada');
        }
    }
} 