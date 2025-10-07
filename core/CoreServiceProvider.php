<?php

namespace Core;

use Illuminate\Support\ServiceProvider;

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
//        $this->mergeConfigFrom(__DIR__ . '/../Config/auth.php', 'auth');
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

        $this->mergeConfigFrom(__DIR__.'/Config/modules.php', 'modules.cms');

    }
}
