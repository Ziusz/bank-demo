<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

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
        if (Role::where('name', 'admin')->count() === 0) {
            Role::create(['name' => 'admin']);
            Role::create(['name' => 'client']);
            Role::create(['name' => 'customer-support']);
        }
    }
}
