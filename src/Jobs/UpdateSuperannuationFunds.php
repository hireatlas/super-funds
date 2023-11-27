<?php

namespace Atlas\LaravelAustralianSuperannuationFunds\Jobs;

use Atlas\LaravelAustralianSuperannuationFunds\SuperannuationFunds;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class UpdateSuperannuationFunds implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SuperannuationFunds $superannuationFunds)
    {
        $superannuationFunds->persist();
    }
}
