<?php

use Atlas\SuperFunds\Downloader;
use Atlas\SuperFunds\Models\SuperFund;
use Atlas\SuperFunds\Parser;
use Atlas\SuperFunds\Persister;

it('can persist the list of super funds', function () {
    /** @var Downloader $downloader */
    $downloader = app(Downloader::class);

    $file = $downloader->download();

    /** @var Parser $parser */
    $parser = app(Parser::class);

    $dtos = $parser->parse($file);

    /** @var Persister $persister */
    $persister = new Persister(SuperFund::class);

    $this->assertDatabaseCount('super_funds', 0);

    $persister->persist($dtos);

    $this->assertDatabaseCount('super_funds', $dtos->count());
});
