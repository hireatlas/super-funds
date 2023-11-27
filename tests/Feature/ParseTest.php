<?php

use Atlas\LaravelAustralianSuperannuationFunds\Downloader;
use Atlas\LaravelAustralianSuperannuationFunds\DTOs\SuperannuationFundDTO;
use Atlas\LaravelAustralianSuperannuationFunds\Parser;

it('can parse the list of superannuation funds', function () {
    /** @var Downloader $downloader */
    $downloader = app(Downloader::class);

    $file = $downloader->download();

    /** @var Parser $parser */
    $parser = app(Parser::class);

    $result = $parser->parse($file);

    expect($result)
        ->not->toBeEmpty();

    expect($result->first())
        ->toBeInstanceOf(SuperannuationFundDTO::class);
});
