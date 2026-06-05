<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;
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
        Volt::mount([
            resource_path('views/livewire'),
        ]);
    }
}
