<?php

use Atlas\LaravelAustralianSuperannuationFunds\Downloader;
use Atlas\LaravelAustralianSuperannuationFunds\Exceptions\DownloadException;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake([
        '*/ok*' => Http::response('this is a test response', 200, ['Content-Type' => 'plain/text']),
        '*/not-found*' => Http::response(null, 404),
    ]);
});

it('can download the list of superannuation funds', function () {
    $downloader = new Downloader(
        'test.com/ok'
    );

    $result = $downloader->download();

    expect($result)->toBe('this is a test response');
});

it('can throw a download exception', function () {
    $downloader = new Downloader(
        'test.com/not-found'
    );

    $result = $downloader->download();
})
    ->throws(DownloadException::class);
