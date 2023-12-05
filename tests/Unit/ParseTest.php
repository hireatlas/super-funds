<?php

use Atlas\SuperFunds\DTOs\SuperFundDTO;
use Atlas\SuperFunds\Exceptions\ParseException;
use Atlas\SuperFunds\Parser;
use Illuminate\Support\Carbon;

it('can parse an empty file', function (string $file) {
    $parser = new Parser();

    $result = $parser->parse($file);

    expect($result)
        ->toBeEmpty();
})
    ->with([
        'empty' => file_get_contents(__DIR__.'/stubs/empty.txt'),
        'empty-with-header-and-footer' => file_get_contents(__DIR__.'/stubs/empty-with-header-and-footer.txt'),
    ]);

it('can parse the list of super funds', function (string $file) {
    $parser = new Parser();

    $result = $parser->parse($file);

    expect($result)
        ->not->toBeEmpty();

    expect($result->first())
        ->toBeInstanceOf(SuperFundDTO::class);
})
    ->with([
        'valid-data' => file_get_contents(__DIR__.'/stubs/valid-data.txt'),
        'valid-single-item' => file_get_contents(__DIR__.'/stubs/valid-single-item.txt'),
        'valid-but-expired-single-item' => file_get_contents(__DIR__.'/stubs/valid-but-expired-single-item.txt'),
    ]);

it('can correctly parse a valid item', function (string $file) {
    $parser = new Parser();

    $result = $parser->parse($file);

    expect($result)
        ->toHaveCount(1);

    /** @var SuperFundDTO $superFund */
    $superFund = $result->first();

    expect($superFund)
        ->toBeInstanceOf(SuperFundDTO::class)
        ->toHaveProperties([
            'abn' => '12345678901',
            'fundName' => 'ACME SUPERANNUATION FUND',
            'usi' => '12345678901001',
            'productName' => 'ACME Superannuation Fund',
            'restrictsContributions' => false,
            'valid' => true,
            'validFrom' => Carbon::parse('2013-07-01', 'Australia/Sydney'),
            'validTo' => null,
        ]);
})
    ->with([
        'valid-single-item' => file_get_contents(__DIR__.'/stubs/valid-single-item.txt'),
    ]);

it('can correctly parse a valid but expired item', function (string $file) {
    $parser = new Parser();

    $result = $parser->parse($file);

    expect($result)
        ->toHaveCount(1);

    /** @var SuperFundDTO $superFund */
    $superFund = $result->first();

    expect($superFund)
        ->toBeInstanceOf(SuperFundDTO::class)
        ->toHaveProperties([
            'abn' => '12345678901',
            'fundName' => 'ACME SUPERANNUATION FUND',
            'usi' => '12345678901001',
            'productName' => 'ACME Superannuation Fund',
            'restrictsContributions' => true,
            'valid' => false,
            'validFrom' => Carbon::parse('2013-07-01', 'Australia/Sydney'),
            'validTo' => Carbon::parse('2014-07-01', 'Australia/Sydney'),
        ]);
})
    ->with([
        'valid-but-expired-single-item' => file_get_contents(__DIR__.'/stubs/valid-but-expired-single-item.txt'),
    ]);

it('can throw an exception when parsing invalid data', function (string $file) {
    $parser = new Parser();

    $result = $parser->parse($file);
})
    ->with([
        'invalid-data' => file_get_contents(__DIR__.'/stubs/invalid-data.txt'),
    ])
    ->throws(ParseException::class);
