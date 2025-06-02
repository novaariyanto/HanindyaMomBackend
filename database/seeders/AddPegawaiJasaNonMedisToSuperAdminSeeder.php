<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;

class AddPegawaiJasaNonMedisToSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role SUPERADMIN
        $superAdminRole = Role::where('name', 'SUPERADMIN')->first();
        
        if (!$superAdminRole) {
            $this->command->error('Role SUPERADMIN tidak ditemukan');
            return;
        }

        // Ambil menu Pegawai Jasa Non Medis
        $pegawaiJasaNonMedisMenu = Menu::where('nama_menu', 'Pegawai Jasa Non Medis')->first();
        
        if (!$pegawaiJasaNonMedisMenu) {
            $this->command->error('Menu Pegawai Jasa Non Medis tidak ditemukan');
            return;
        }

        // Tambahkan menu ke role jika belum ada
        $existingRoleMenu = RoleMenu::where('role_id', $superAdminRole->id)
            ->where('menu_id', $pegawaiJasaNonMedisMenu->id)
            ->first();
            
        if (!$existingRoleMenu) {
            RoleMenu::create([
                'role_id' => $superAdminRole->id,
                'menu_id' => $pegawaiJasaNonMedisMenu->id
            ]);
            $this->command->info('Menu Pegawai Jasa Non Medis berhasil ditambahkan ke role SUPERADMIN');
        } else {
            $this->command->info('Menu Pegawai Jasa Non Medis sudah ada di role SUPERADMIN');
        }

        // Pastikan parent menu Master Data juga ada di role SUPERADMIN
        $parentMenu = Menu::where('nama_menu', 'Master Data')->first();
        
        if ($parentMenu) {
            $existingParentRoleMenu = RoleMenu::where('role_id', $superAdminRole->id)
                ->where('menu_id', $parentMenu->id)
                ->first();
                
            if (!$existingParentRoleMenu) {
                RoleMenu::create([
                    'role_id' => $superAdminRole->id,
                    'menu_id' => $parentMenu->id
                ]);
                $this->command->info('Menu parent Master Data berhasil ditambahkan ke role SUPERADMIN');
            }
        }
    }
} 