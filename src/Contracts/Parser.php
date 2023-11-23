<?php

namespace Atlas\LaravelAustralianSuperannuationFunds\Contracts;

use Illuminate\Support\Collection;

interface Parser
{
    public function parse(string $file): Collection;
}
