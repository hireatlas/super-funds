<?php

namespace Atlas\SuperFunds\Contracts;

use Illuminate\Support\Collection;

interface Parser
{
    public function parse(string $file): Collection;
}
