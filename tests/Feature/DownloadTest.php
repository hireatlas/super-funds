<?php

use Atlas\LaravelAustralianSuperannuationFunds\Downloader;

it('can download the list of superannuation funds', function () {
    /** @var Downloader $downloader */
    $downloader = app(Downloader::class);

    $result = $downloader->download();

    expect($result)
        ->toBeString();
});
