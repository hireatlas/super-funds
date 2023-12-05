<?php

namespace Atlas\SuperFunds\Console;

use Atlas\SuperFunds\SuperFunds;
use Illuminate\Console\Command;

class UpdateSuperFunds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'super-funds:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Persists the latest list of super funds.';

    public function handle(SuperFunds $superFunds): int
    {
        $models = $superFunds->persist();

        $this->info(sprintf('Persisted %d models to the database.', $models->count()));

        return 0;
    }
}
