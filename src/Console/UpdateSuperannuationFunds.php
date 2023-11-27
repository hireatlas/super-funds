<?php

namespace Atlas\LaravelAustralianSuperannuationFunds\Console;

use Atlas\LaravelAustralianSuperannuationFunds\SuperannuationFunds;
use Illuminate\Console\Command;

class UpdateSuperannuationFunds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'superannuation-funds:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Persists the latest list of superannuation funds.';

    public function handle(SuperannuationFunds $superannuationFunds)
    {
        $superannuationFunds->persist();
    }
}
