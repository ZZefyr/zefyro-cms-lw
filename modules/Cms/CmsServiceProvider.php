<?php

namespace Modules\Cms;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Zaregistruje vše potřebné pro modul (config, bindings atd.)
     */
    public function register()
    {
        // 1. Merge config (pokud má modul vlastní config)
        $this->mergeConfigFrom(__DIR__.'/Config/module.php', 'cms');

        // 2. Registrace vlastních helper funkcí (pokud existují)
        if (file_exists(__DIR__.'/Helpers/helpers.php')) {
            require_once __DIR__.'/Helpers/helpers.php';
        }
    }

    /**
     * Bootstrapping modulových věcí
     */
    public function boot()
    {
        // 1. Registrace migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        // 2. Registrace views s vlastním namespace
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'cms');

        // 3. Registrace rout
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');

        // 4. Publikování assetů (např. js, css) do public folderu
        $this->publishes([
            __DIR__.'/Resources/assets' => public_path('modules/module'),
        ], 'cms-assets');

        // 5. Eventy, policies nebo middleware (pokud modul má vlastní)
        // $this->loadRoutesFrom(__DIR__.'/routes/middleware.php');
        // $this->app['router']->aliasMiddleware('cms-mw', \Modules\Cms\Http\Middleware\CmsMiddleware::class);
    }
}
