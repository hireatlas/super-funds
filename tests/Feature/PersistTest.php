<?php

use Atlas\LaravelAustralianSuperannuationFunds\Downloader;
use Atlas\LaravelAustralianSuperannuationFunds\Models\SuperannuationFund;
use Atlas\LaravelAustralianSuperannuationFunds\Parser;
use Atlas\LaravelAustralianSuperannuationFunds\Persister;

it('can persist the list of superannuation funds', function () {
    /** @var Downloader $downloader */
    $downloader = app(Downloader::class);

    $file = $downloader->download();

    /** @var Parser $parser */
    $parser = app(Parser::class);

    $dtos = $parser->parse($file);

    /** @var Persister $persister */
    $persister = new Persister(SuperannuationFund::class);

    $this->assertDatabaseCount('superannuation_funds', 0);

    $persister->persist($dtos);

    $this->assertDatabaseCount('superannuation_funds', $dtos->count());
});
