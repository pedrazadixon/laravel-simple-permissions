<?php

namespace Pedrazadixon\LaravelSimplePermissions\Providers;

use Pedrazadixon\LaravelSimplePermissions\Console\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

class LaravelSimplePermissionsProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../views', 'laravel-simple-permissions');
        $this->app['router']->aliasMiddleware(
            'permissions',
            \Pedrazadixon\LaravelSimplePermissions\Middleware\Permissions::class
        );

        $this->publishes([
            __DIR__ . '/../views/' => resource_path('views/vendor/laravel-simple-permissions'),
        ], 'laravel-simple-permissions-views');
    }
}
