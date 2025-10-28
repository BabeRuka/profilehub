<?php

namespace BabeRuka\ProfileHub\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class, 

    ];
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareGroups = [

    ];

    protected $routeMiddleware = [
        'initiate.session' => \BabeRuka\ProfileHub\Http\Middleware\InitiateSession::class,   
        'force.profile.update' => \BabeRuka\ProfileHub\Http\Middleware\ForceProfileUpdate::class, 
    ];
}

