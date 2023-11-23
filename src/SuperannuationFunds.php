<?php

namespace Atlas\LaravelAustralianSuperannuationFunds;

use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Downloader;
use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Parser;
use Illuminate\Support\Collection;

class SuperannuationFunds
{
    public function __construct(
        private Downloader $downloader,
        private Parser $parser
    ) {
        //
    }

    public function fetch(): Collection
    {
        $file = $this->downloader->download();

        $superannuationFunds = $this->parser->parse($file);

        return $superannuationFunds;
    }
}
