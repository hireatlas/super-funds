<?php

namespace Atlas\SuperFunds;

use Atlas\SuperFunds\Contracts\Downloader as DownloaderContract;
use Atlas\SuperFunds\Exceptions\DownloadException;
use Illuminate\Support\Facades\Http;

class Downloader implements DownloaderContract
{
    public function __construct(
        private string $url = 'https://superfundlookup.gov.au/Tools/DownloadUsiList?download=usi'
    ) {
        //
    }

    public function download(): string
    {
        try {
            $response = Http::throw()
                ->get($this->url);

            return $response->body();
        } catch (\Throwable|\Exception $exception) {
            throw new DownloadException(previous: $exception);
        }
    }
}
