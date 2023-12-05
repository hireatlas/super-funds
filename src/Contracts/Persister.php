<?php

namespace Atlas\SuperFunds\Contracts;

use Illuminate\Support\Collection;

interface Persister
{
    public function persist(Collection $collection): Collection;
}
