<?php

namespace Core;

use Core\Http\Livewire\Admin\Dashboard;
use Core\Http\Livewire\Admin\Menu;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Všechny interní providery jádra, které chceme registrovat.
     */
    protected array $providers = [
    ];

    /**
     * Registrace služeb.
     */
    public function register(): void
    {
        // Registrace ostatních core providerů
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }

        // Registrace vlastních konfiguračních souborů
        //        $this->mergeConfigFrom(__DIR__ . '/../Config/permissions.php', 'permissions');
    }

    /**
     * Bootstrapování jádra
     */
    public function boot(): void
    {
        // Načti migrationy jádra (např. users, roles, permissions)
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/Routes/admin.php');

        // Načti globální view (např. email templates, layouty)
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'core');

        // Publikuj assety (např. společné CSS/JS pro admin)
        $this->publishes([
            __DIR__ . '/../Resources/assets' => public_path('core'),
        ], 'core-assets');

        $this->registerLivewireComponents();

//        Livewire::component('admin.logout-button', \Core\Http\Livewire\Admin\LogoutButton::class);


        $this->mergeConfigFrom(__DIR__.'/Config/modules.php', 'modules.cms');

    }


    protected function registerLivewireComponents()
    {
        $componentPath = __DIR__.'/Http/Livewire/Admin';

        if (!is_dir($componentPath)) {
            return;
        }

        foreach (glob($componentPath.'/*.php') as $file) {
            $className = basename($file, '.php');
            $componentName = 'admin.' . \Illuminate\Support\Str::kebab($className);
            $fullClass = "Core\\Http\\Livewire\\Admin\\{$className}";

            Livewire::component($componentName, $fullClass);
        }
    }
}
