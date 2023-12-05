<?php

use Atlas\SuperFunds\Downloader;
use Atlas\SuperFunds\DTOs\SuperFundDTO;
use Atlas\SuperFunds\Parser;

it('can parse the list of super funds', function () {
    /** @var Downloader $downloader */
    $downloader = app(Downloader::class);

    $file = $downloader->download();

    /** @var Parser $parser */
    $parser = app(Parser::class);

    $result = $parser->parse($file);

    expect($result)
        ->not->toBeEmpty();

    expect($result->first())
        ->toBeInstanceOf(SuperFundDTO::class);
});
