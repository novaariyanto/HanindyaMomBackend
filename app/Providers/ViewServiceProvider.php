<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
             // Share setting data to all views
             View::composer('*', function ($view) {
                $setting = Setting::first(); // Ambil data setting
                $view->with('setting', $setting); // Kirim data ke semua view
            });
    }
}
