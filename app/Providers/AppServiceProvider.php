<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // get the department from settings table
        $setting = \App\Models\Setting::latest()->first();
        $department = $setting ? $setting->department : null;
        view()->share('department', $department);
    }
}
