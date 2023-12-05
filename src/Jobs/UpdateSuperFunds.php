<?php

namespace Atlas\SuperFunds\Jobs;

use Atlas\SuperFunds\SuperFunds;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class UpdateSuperFunds implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SuperFunds $superFunds)
    {
        $superFunds->persist();
    }
}
