<?php

namespace Core;

use Core\Livewire\Admin\Grid\UserGrid;
use Core\Services\MenuService;
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

        $this->app->singleton(MenuService::class);

        // Registrace vlastních konfiguračních souborů
        //        $this->mergeConfigFrom(__DIR__ . '/../Config/permissions.php', 'permissions');
    }

    /**
     * Bootstrapování jádra
     */
    public function boot(MenuService $menu): void
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

        Livewire::component('admin.grid.user-grid', UserGrid::class);

        $this->registerLivewireComponents();

        $this->mergeConfigFrom(__DIR__.'/Config/modules.php', 'modules.cms');

        $menu->registerMultiple([
            'stats' => [
                'id' => 'stats',
                'label' => 'Hlavní stránka',
                'icon' => 'heroicon-o-home',
                'route' => 'admin.dashboard',
                'order' => 1,
                'group' => 'main',
            ],
            'user' => [
                'id' => 'user',
                'label' => 'Uživatelé',
                'icon' => 'heroicon-o-users',
                'route' => 'admin.dashboard',
                'order' => 1,
                'group' => 'main',
            ],
            'settings' => [
                'id' => 'settings',
                'label' => 'Nastavení',
                'icon' => 'heroicon-o-cog-6-tooth',
                'route' => 'admin.settings',
                'order' => 999,
                'group' => 'settings',
            ],
        ]);

    }


    protected function registerLivewireComponents()
    {
        $componentPath = __DIR__.'/Livewire/Admin';

        if (!is_dir($componentPath)) {
            return;
        }

        foreach (glob($componentPath.'/*.php') as $file) {
            $className = basename($file, '.php');
            $componentName = 'admin.' . \Illuminate\Support\Str::kebab($className);
            $fullClass = "Core\\Livewire\\Admin\\{$className}";

            Livewire::component($componentName, $fullClass);
        }
    }
}
