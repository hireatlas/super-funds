<?php

namespace Atlas\LaravelAustralianSuperannuationFunds\Tests;

use Atlas\LaravelAustralianSuperannuationFunds\ServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
