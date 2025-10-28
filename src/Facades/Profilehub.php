<?php

declare(strict_types=1);

namespace BabeRuka\ProfileHub\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void publicApiRoutes
 * @method static void apiRoutes
 * @method static void publicWebRoutes
 * @method static void webRoutes 
 */
class Profilehub extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'profilehub';
    }
}
