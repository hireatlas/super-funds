<?php

namespace Atlas\LaravelAustralianSuperannuationFunds;

use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Downloader as DownloaderContract;
use Atlas\LaravelAustralianSuperannuationFunds\Exceptions\DownloadException;
use Illuminate\Support\Facades\Http;

class Downloader implements DownloaderContract
{
    public function __construct(
        private string $url = 'https://superfundlookup.gov.au/Tools/DownloadUsiList?download=usi'
    ) {
        //
    }

    public function download(): string {
        $response = Http::get($this->url);

        if (!$response->successful()) {
            throw new DownloadException();
        }

        return $response->body();
    }
}



