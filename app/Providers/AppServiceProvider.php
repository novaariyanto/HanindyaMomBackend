<?php

namespace App\Providers;

use App\Models\Menu;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use View;

use Illuminate\Support\Facades\Cache;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    
    public function boot(): void
    {
        Carbon::setLocale('id');

        // Gunakan View Composer untuk mengirim data menu ke semua view
        View::composer('*', function ($view) {
            // Ambil pengguna yang sedang login
            $user = Auth::user();
    
            // Jika pengguna tidak login, kirim menu kosong
            if (!$user) {
                $view->with('menus', collect());
                return;
            }
    
            $roleid = Auth::user()->roles()->first()->id;

            // Kunci cache unik berdasarkan ID pengguna
            $cacheKey = 'user_menus_' . $roleid;
    
            // Ambil menu dari cache atau buat jika belum ada
            $menus = Cache::remember($cacheKey, now()->addDay(), function () use ($user) {
                // Ambil semua menu utama beserta submenu-nya
                $allMenus = Menu::with('children')
                    ->orderBy('order')
                    ->mainMenus()
                    ->get();
    
                // Filter menu berdasarkan role pengguna
                return $allMenus->filter(function ($menu) use ($user) {
                    // Periksa apakah role pengguna memiliki akses ke menu ini
                    return $menu->roles->pluck('id')->intersect($user->roles->pluck('id'))->isNotEmpty();
                })->map(function ($menu) use ($user) {
                    // Rekursif filter submenu
                    if ($menu->children) {
                        $menu->children = $menu->children->filter(function ($child) use ($user) {
                            return $child->roles->pluck('id')->intersect($user->roles->pluck('id'))->isNotEmpty();
                        });
                    }
                    return $menu;
                })->values();
            });
    
            // Kirim data menu yang telah difilter ke semua view
            $view->with('menus', $menus);
        });
    }
}
