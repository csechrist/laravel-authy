<?php

namespace Csechrist\LaravelChargebee;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Csechrist\LaravelChargebee\Console\InstallChargebee;
use Csechrist\LaravelChargebee\Console\ImportProducts;
use Stripe\Stripe;
use Stripe\Util\LoggerInterface;

class LaravelChargebeeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerLogger();
        $this->registerRoutes();
        $this->registerResources();
        $this->registerMigrations();
        $this->registerPublishing();
        $this->registerCommands();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->configure();

        // Register the main class to use with the facade
        $this->app->singleton('laravel-authy', function () {
            return new LaravelAuthy;
        });
    }

     /**
     * Setup the configuration for Chargebee.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/authy.php', 'authy'
        );
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if (LaravelAuthy::$registersRoutes) {
            Route::group([
                'prefix' => config('authy.path'),
                'namespace' => 'Csechrist\LaravelAuthy\Http\Controllers',
                'as' => 'authy.',
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            });
        }
    }

    /**
     * Register the package resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'chargebee');
    }

    /**
     * Register the package migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        if (LaravelAuthy::$runsMigrations && $this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/authy.php' => $this->app->configPath('authy.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations/add_to_users_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . 'add_to_users_table.php'),

                // you can add any number of migrations here
            ], 'migrations');

            $this->publishes([
                __DIR__.'/../resources/views' => $this->app->resourcePath('views/vendor/authy'),
            ], 'views');
        }
    }

    /**
     * Register the package's commands
     *
     * @return void
     */
    protected function registerCommands() {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallAuthy::class
            ]);
        }
    }
}
