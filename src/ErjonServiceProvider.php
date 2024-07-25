<?php

namespace Erjon\LaravelLicense;

use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\VerifyCsrfToken;
use Erjon\LaravelLicense\Commands\ActivateLicenseCommand;
use Erjon\LaravelLicense\Commands\AddLicenseCommand;
use Erjon\LaravelLicense\Http\Middleware\ActiveLicense;
use Erjon\LaravelLicense\Http\Middleware\NonActiveLicense;
use Erjon\LaravelLicense\Support\LicenseChecker;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ErjonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadViewsFrom(__DIR__. '/view', 'license');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->mergeConfigFrom(__DIR__.'/config/license.php', 'license');

        $this->publishes([
            __DIR__ . '/view' => resource_path('views/vendor/license'),
            __DIR__.'/config' => config_path('vendor/license.php')
        ], 'license');

        $this->addLicenseMiddleware();
        $this->createWebMiddleware();

        if ($this->app->runningInConsole()) {
            $this->commands([
                AddLicenseCommand::class,
                ActivateLicenseCommand::class
            ]);
        }
    }

    public function register(): void
    {
        $this->app->bind('License', function () {
            return new LicenseChecker();
        });
    }

    private function addLicenseMiddleware(): void
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('active-license', ActiveLicense::class);

        $this->app->booted(function () use($router) {
            $router->pushMiddlewareToGroup('web', ActiveLicense::class);
        });
    }

    private function createWebMiddleware(): void
    {
        $router = $this->app['router'];

        $this->app->booted(function () use($router) {
            $router->pushMiddlewareToGroup('package-web', EncryptCookies::class);
            $router->pushMiddlewareToGroup('package-web', AddQueuedCookiesToResponse::class);
            $router->pushMiddlewareToGroup('package-web', StartSession::class);
            $router->pushMiddlewareToGroup('package-web', ShareErrorsFromSession::class);
            $router->pushMiddlewareToGroup('package-web', VerifyCsrfToken::class);
            $router->pushMiddlewareToGroup('package-web', SubstituteBindings::class);
            $router->pushMiddlewareToGroup('package-web', NonActiveLicense::class);
        });
    }
}
