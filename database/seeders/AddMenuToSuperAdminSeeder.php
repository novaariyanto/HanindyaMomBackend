<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use Spatie\Permission\Models\Permission;

class AddMenuToSuperAdminSeeder extends Seeder
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

        // Ambil menu parent Indeks
        $parentMenu = Menu::where('nama_menu', 'Indeks')->first();
        
        if (!$parentMenu) {
            $this->command->error('Menu parent Indeks tidak ditemukan');
            return;
        }

        // Tambahkan parent menu ke role jika belum ada
        $existingParentRoleMenu = RoleMenu::where('role_id', $superAdminRole->id)
            ->where('menu_id', $parentMenu->id)
            ->first();
            
        if (!$existingParentRoleMenu) {
            RoleMenu::create([
                'role_id' => $superAdminRole->id,
                'menu_id' => $parentMenu->id
            ]);
            $this->command->info('Menu parent Indeks berhasil ditambahkan ke role SUPERADMIN');
        }

        // Daftar menu yang akan ditambahkan
        $menuRoutes = [
            'indeks-jasa-tidak-langsung.index',
            'indeks-jasa-langsung-non-medis.index',
            'indeks-struktural.index'
        ];

        foreach ($menuRoutes as $route) {
            // Ambil menu berdasarkan route
            $menu = Menu::where('route', $route)->first();
            
            if ($menu) {
                // Cek apakah relasi sudah ada
                $existingRoleMenu = RoleMenu::where('role_id', $superAdminRole->id)
                    ->where('menu_id', $menu->id)
                    ->first();
                    
                if (!$existingRoleMenu) {
                    // Tambahkan menu ke role
                    RoleMenu::create([
                        'role_id' => $superAdminRole->id,
                        'menu_id' => $menu->id
                    ]);
                    
                    $this->command->info("Menu {$menu->nama_menu} berhasil ditambahkan ke role SUPERADMIN");
                } else {
                    $this->command->info("Menu {$menu->nama_menu} sudah ada di role SUPERADMIN");
                }
                
                // Tambahkan permission jika ada
                $permission = Permission::where('name', $route)->first();
                if ($permission && !$superAdminRole->hasPermissionTo($permission)) {
                    $superAdminRole->givePermissionTo($permission);
                    $this->command->info("Permission {$route} berhasil ditambahkan ke role SUPERADMIN");
                }
            } else {
                $this->command->error("Menu dengan route {$route} tidak ditemukan");
            }
        }
    }
} 