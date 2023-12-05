<?php

use Atlas\SuperFunds\Downloader;

it('can download the list of super funds', function () {
    /** @var Downloader $downloader */
    $downloader = app(Downloader::class);

    $result = $downloader->download();

    expect($result)
        ->toBeString();
});
