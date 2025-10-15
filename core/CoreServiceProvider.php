<?php

namespace Core;

use Core\Livewire\Admin\Grids\UserGrid;
use Core\Services\AdminService;
use Core\Services\MenuService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
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
        $this->app->singleton(AdminService::class);

        // Registrace vlastních konfiguračních souborů
        //        $this->mergeConfigFrom(__DIR__ . '/../Config/permissions.php', 'permissions');
    }

    /**
     * Bootstrapování jádra
     */
    public function boot(MenuService $menu, AdminService $adminService): void
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
        $this->registerBladeComponents();

        $this->mergeConfigFrom(__DIR__.'/Config/modules.php', 'modules.cms');

        $menu->registerMultiple([
            'stats' => [
                'id' => 'stats',
                'label' => 'Hlavní stránka',
                'icon' => 'heroicon-o-home',
                'route' => 'admin.pages.dashboard',
                'order' => 1,
                'group' => 'main',
            ],
            'user' => [
                'id' => 'user',
                'label' => 'Uživatelé',
                'icon' => 'heroicon-o-users',
                'route' => 'admin.pages.dashboard',
                'order' => 1,
                'group' => 'main',
            ],
            'settings' => [
                'id' => 'settings',
                'label' => 'Nastavení',
                'icon' => 'heroicon-o-cog-6-tooth',
                'route' => 'admin.pages.settings',
                'order' => 999,
                'group' => 'settings',
            ],
        ]);

        $adminService->allowContentMultiple(
            [
                'admin' => 'core::admin.pages.stats',
                'user' => 'core::admin.pages.user',
                'stats' => 'core::admin.pages.stats',
                'orders' => 'core::admin.pages.orders',
                'products' => 'core::admin.pages.products',
                'settings' => 'core::admin.pages.settings',
            ]
        );

    }
    protected function registerBladeComponents()
    {
        Blade::componentNamespace('Core\\View\\Components\\Form', 'form');

        // Nebo jednoduše alias pro view komponenty
        Blade::component('core::components.form.input', 'form-input');
        Blade::component('core::components.form.select', 'form-select');
        Blade::component('core::components.form.textarea', 'form-textarea');
        Blade::component('core::components.form.checkbox', 'form-checkbox');
    }

    protected function registerLivewireComponents(): void {
        $componentPath = __DIR__.'/Livewire/Admin';

        if (!is_dir($componentPath)) {
            return;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($componentPath, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($files as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $relativePath = Str::of($file->getPathname())
                ->after($componentPath . DIRECTORY_SEPARATOR)
                ->before('.php')
                ->replace(DIRECTORY_SEPARATOR, '/');

            $parts = explode('/', $relativePath);
            $className = array_pop($parts);

            $componentName = 'core::admin.' . collect([...$parts, $className])
                    ->map(fn($part) => Str::kebab($part))
                    ->implode('.');

            $fullClass = 'Core\\Livewire\\Admin\\' .
                (!empty($parts) ? implode('\\', $parts) . '\\' : '') .
                $className;

            Livewire::component($componentName, $fullClass);
        }
    }
}
