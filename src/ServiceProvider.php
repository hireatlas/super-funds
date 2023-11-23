<?php

namespace Atlas\LaravelAustralianSuperannuationFunds;

use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Downloader as DownloaderContract;
use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Parser as ParserContract;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->bind(DownloaderContract::class, function () {
            return new Downloader();
        });

        $this->app->bind(ParserContract::class, function () {
            return new Parser();
        });
    }
}
