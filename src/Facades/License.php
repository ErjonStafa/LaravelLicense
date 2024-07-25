<?php

namespace Erjon\LaravelLicense\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void activate(string $license)
 * @method static bool isActivated()
 */
class License extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'License';
    }
}
