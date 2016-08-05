<?php

namespace TypiCMS\Modules\Menus\Providers;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Custom\Services\Cache\LaravelCache;
use TypiCMS\Modules\Menus\Custom\Models\Menu;
use TypiCMS\Modules\Menus\Custom\Models\Menulink;
use TypiCMS\Modules\Menus\Custom\Repositories\CacheDecorator;
use TypiCMS\Modules\Menus\Custom\Repositories\EloquentMenu;
use TypiCMS\Modules\Menus\Custom\Repositories\EloquentMenulink;
use TypiCMS\Modules\Menus\Custom\Repositories\MenulinkCacheDecorator;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.menus'
        );
        $this->mergeConfigFrom(
            __DIR__.'/../config/menulinksconfig.php', 'typicms.menulinks'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['menus' => []], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'menus');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'menus');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/menus'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Menus',
            'TypiCMS\Modules\Menus\Custom\Facades\Facade'
        );
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Menus\Custom\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Menus\Custom\Composers\SidebarViewComposer');

        $app->singleton('TypiCMS.menus', function (Application $app) {
            $with = [
                'menulinks' => function (HasMany $query) {
                    $query->online();
                },
                'menulinks.page',
            ];

            return $app->make('TypiCMS\Modules\Menus\Custom\Repositories\MenuInterface')->all($with);
        });

        $app->bind('TypiCMS\Modules\Menus\Custom\Repositories\MenuInterface', function (Application $app) {
            $repository = new EloquentMenu(new Menu());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['menus', 'menulinks', 'pages'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Menus\Custom\Repositories\MenulinkInterface', function (Application $app) {
            $repository = new EloquentMenulink(new Menulink());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'menulinks', 10);

            return new MenulinkCacheDecorator($repository, $laravelCache);
        });
    }
}
