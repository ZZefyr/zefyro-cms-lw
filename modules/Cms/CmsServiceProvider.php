<?php

namespace Modules\Cms;

use Core\Services\AdminService;
use Core\Services\MenuService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Livewire;

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
    public function boot(MenuService $menu, AdminService $adminService): void
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

        $menu->registerMultiple([
            'cmsDisplay' => [
                'id' => 'cms-display',
                'label' => 'Vzhled a obsah',
                'icon' => 'heroicon-o-document-text',
                'route' => 'admin.pages.cms-display',
                'order' => 1,
                'group' => 'main',
                'subItems' => [
                    'cmsPage' => [
                        'id' => 'page-list',
                        'label' => 'Podstránky',
                        'icon' => 'heroicon-o-document-text',
                        'route' => 'admin.pages.cms-page',
                        'order' => 1,
                        'group' => 'main',
                    ],
                    'cmsPageCategory' => [
                        'id' => 'cms-page-category',
                        'label' => 'Kategorie podstránek',
                        'icon' => 'heroicon-o-folder',
                        'route' => 'admin.pages.cms-page-category',
                        'order' => 1,
                        'group' => 'main',
                    ]],
            ],
            ]);
        $this->registerLivewireComponents();

        $adminService->allowContentMultiple(
            [
                'page-list' => 'cms::admin.pages.page-list',
            ]
        );
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

            $componentName = 'cms::admin.' . collect([...$parts, $className])
                    ->map(fn($part) => Str::kebab($part))
                    ->implode('.');

            $fullClass = 'Modules\\Cms\\Livewire\\Admin\\' .
                (!empty($parts) ? implode('\\', $parts) . '\\' : '') .
                $className;

            Livewire::component($componentName, $fullClass);
        }
    }

}
