<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        $activeTheme = config('view.theme', env('APP_THEME', 'default'));

        $themePath = resource_path("views/{$activeTheme}");
        if (is_dir($themePath)) {
            View::prependLocation($themePath);
        }

        View::share('activeTheme', $activeTheme);
    }
}
