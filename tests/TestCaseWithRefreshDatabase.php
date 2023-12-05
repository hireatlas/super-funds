<?php

namespace Atlas\SuperFunds\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCaseWithRefreshDatabase extends TestCase
{
    use RefreshDatabase;

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'sqlite',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);
    }
}
