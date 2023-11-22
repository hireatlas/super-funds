<?php

use Atlas\LaravelAustralianSuperannuationFunds\SuperannuationFunds;
use Illuminate\Support\Facades\Route;

Route::get('/superannuation-funds', function () {
    /** @var SuperannuationFunds $fetcher */
    $fetcher = app(SuperannuationFunds::class);

    $superannuationFunds = $fetcher->fetch();

    return $superannuationFunds;
});

