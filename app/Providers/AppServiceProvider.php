<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Livewire\Volt\Volt;
use App\Models\Theme;

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
        // AppServiceProvider.php — dans boot()
        app()->setLocale(session('locale', 'fr'));
        View::composer('layouts.partials.header', function ($view) {
            $themes = Theme::pluck('nom_theme');
            $view->with('themes', $themes);
        });
        Volt::mount([
            resource_path('views/livewire'),
        ]);
    }
}
