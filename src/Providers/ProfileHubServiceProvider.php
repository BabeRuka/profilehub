<?php

namespace BabeRuka\ProfileHub\Providers; 

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;  
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;  
use Illuminate\Auth\Middleware\Authenticate;

class ProfileHubServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register related providers
        $this->app->register(RouteServiceProvider::class);

        // Bind service
        $this->app->singleton(ProfileHubService::class, function ($app) {
            return new \BabeRuka\ProfileHub\Services\ProfileHubService();
        });

        // Facade
        $this->app->bind('profilehub', static function (Application $app) {
            return $app->make(\BabeRuka\ProfileHub\Services\ProfileHubService::class);
        });

        // Helper Facade Binding
        //$this->app->bind('profilehub.helper', \BabeRuka\ProfileHub\Helpers\Helper::class);

        // Config
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/profilehub.php',
            'profilehub'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->publishes([__DIR__.'/../../config/profilehub.php' => config_path('profilehub.php'),], 'profilehub-config');
        $this->publishes([
            __DIR__.'/../../assets/css' => public_path('vendor/profilehub/css'),
            __DIR__.'/../../assets/js' => public_path('vendor/profilehub/js'),
            __DIR__.'/../../assets/fonts' => public_path('vendor/fonts'),  
            __DIR__.'/../../assets/images' => public_path('vendor/images'),  
            __DIR__.'/../../assets/favicon' => public_path('vendor/favicon'),   
            __DIR__.'/../../assets/addons' => public_path('vendor/addons'),  
        ], 'profilehub-assets'); 

        $this->publishes([
            __DIR__.'/../../resources/views/profilehub' => resource_path('views/vendor/profilehub'),
        ], 'profilehub-views');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \BabeRuka\ProfileHub\Console\Commands\MigrateProfilehubCommand::class,
            ]);
        }
    

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'profilehub');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php'); 
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');

        $router->aliasMiddleware('initiate.session', \BabeRuka\ProfileHub\Http\Middleware\InitiateSession::class);
        $router->aliasMiddleware('force.profile.update', \BabeRuka\ProfileHub\Http\Middleware\ForceProfileUpdate::class);
    }
}
