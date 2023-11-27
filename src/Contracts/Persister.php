<?php

namespace Atlas\LaravelAustralianSuperannuationFunds\Contracts;

use Illuminate\Support\Collection;

interface Persister
{
    public function persist(Collection $collection): Collection;
}
