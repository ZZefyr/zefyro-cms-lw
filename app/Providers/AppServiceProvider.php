<?php

namespace App\Providers;

use Core\CoreServiceProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Cms\CmsServiceProvider;
use Modules\Eshop\EshopServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerModules();
    }

    protected function registerModules()
    {
        $modules = [
            CoreServiceProvider::class,
            CmsServiceProvider::class,
//            EshopServiceProvider::class,
        ];

        foreach ($modules as $module) {
            $this->app->register($module);
        }
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
