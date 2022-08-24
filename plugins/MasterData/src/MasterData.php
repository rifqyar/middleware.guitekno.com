<?php

namespace Vanguard\MasterData;

use Route;
use Illuminate\Database\Eloquent\Factory;
use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class MasterData extends Plugin
{
    /**
     * A sidebar item for the plugin.
     * @return Item|null
     */
    public function sidebar()
    {
        $refBank = Item::create(__('Ref Bank'))
            ->route('masterdata.refbank')
            ->active("master-data/bank");

        $bankSecret = Item::create(__('Bank Secret'))
            ->route('masterdata.bankSecret')
            ->active("master-data/bank-secret");

        $bankEndpoint = Item::create(__('Bank Endpoint'))
            ->route('masterdata.bankEndpoint')
            ->active("master-data/bank-endpoint*");

        return Item::create(__('Master Data'))
            ->href('#masterData-dropdown')
            ->icon('fas fa-database')
            ->addChildren([
                $refBank,
                $bankSecret,
                $bankEndpoint
            ]);
    }

    /**
     * Register plugin services required.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'master-data');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->mapRoutes();

        $this->registerFactories();

        $this->publishAssets();
    }

    /**
     * Register plugin configuration files.
     */
    protected function registerConfig()
    {
        $configPath = __DIR__.'/../config/config.php';

        $this->publishes([$configPath => config_path('master-data.php')], 'config');

        $this->mergeConfigFrom($configPath, 'master-data');
    }

    /**
     * Register plugin views.
     *
     * @return void
     */
    protected function registerViews()
    {
        $viewsPath = __DIR__.'/../resources/views';

        $this->publishes([
            $viewsPath => resource_path('views/plugins/master-data')
        ], 'views');

        $this->loadViewsFrom($viewsPath, 'master-data');
    }

    /**
     * Map all plugin related routes.
     */
    protected function mapRoutes()
    {
        $this->mapWebRoutes();

        if ($this->app['config']->get('auth.expose_api')) {
            $this->mapApiRoutes();
        }
    }

    /**
     * Map web plugin related routes.
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'namespace' => 'Vanguard\MasterData\Http\Controllers\Web',
            'middleware' => 'web',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * Map API plugin related routes.
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'namespace' => 'Vanguard\MasterData\Http\Controllers\Api',
            'middleware' => 'api',
            'prefix' => 'api',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function registerFactories()
    {
        if (! $this->app->environment('production') && $this->app->runningInConsole()) {
            $this->app->make(Factory::class)->load(__DIR__ . '/../database/factories');
        }
    }

    /**
     * Publish public assets.
     *
     * @return void
     */
    protected function publishAssets()
    {
        $this->publishes([
            realpath(__DIR__.'/../dist') => $this->app['path.public'].'/vendor/plugins/master-data',
        ], 'public');
    }
}
