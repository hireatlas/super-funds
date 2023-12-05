<?php

namespace Atlas\SuperFunds;

use Atlas\SuperFunds\Contracts\Downloader as DownloaderContract;
use Atlas\SuperFunds\Contracts\Parser as ParserContract;
use Atlas\SuperFunds\Contracts\Persister as PersisterContract;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMigrations();
        $this->registerPublishing();
        $this->registerCommands();
    }

    public function register()
    {
        $this->app->bind(DownloaderContract::class, function () {
            return new Downloader();
        });

        $this->app->bind(ParserContract::class, function () {
            return new Parser();
        });

        $this->app->bind(PersisterContract::class, function () {
            return new Persister(SuperFunds::$model);
        });
    }

    /**
     * Register the package migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        if (SuperFunds::$runsMigrations && $this->app->runningInConsole()) {
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
                __DIR__.'/../database/migrations' => $this->app->databasePath('migrations'),
            ], 'super-funds-migrations');
        }
    }

    /**
     * Register the package's commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\UpdateSuperFunds::class,
            ]);
        }
    }
}
