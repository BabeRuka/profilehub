<?php

namespace BabeRuka\ProfileHub\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your package's "routes" directory relative to the package root.
     *
     * @var string
     */
    protected $packageRoutes = 'routes';
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'BabeRuka\ProfileHub\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            $this->loadPackageRoutes();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->loadPackageRoutes();
    }

    /**
     * Load the package routes.
     *
     * @return void
     */
    protected function loadPackageRoutes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        $routePath = __DIR__ . '/' . $this->packageRoutes . '/web.php';
        if (file_exists($routePath)) {
            Route::middleware('web')
                ->group($routePath);
        }

        $apiRoutePath = __DIR__ . '/' . $this->packageRoutes . '/api.php';
        if (file_exists($apiRoutePath)) {
            Route::middleware('api')
                ->prefix('api') // You might want a specific prefix for your package's API routes
                ->group($apiRoutePath);
        }
    }
}