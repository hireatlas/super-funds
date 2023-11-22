<?php

namespace Atlas\LaravelAustralianSuperannuationFunds;

use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Parser as ParserContract;
use Atlas\LaravelAustralianSuperannuationFunds\DTOs\SuperannuationFund;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class Parser implements ParserContract
{
    public function parse(string $file): Collection {
        return collect(explode("\r\n", $file))
            ->skip(2) // Headers and separator
            ->reverse()
            ->skip(5) // Footer
            ->reverse()
            ->values()
            ->map(function (string $row) {
                $row = new Stringable($row);

                $validFrom = Carbon::parse(
                    $row
                        ->substr(460, 10)
                        ->trim(),
                    'Australia/Sydney'
                );

                $validTo = Carbon::parse(
                    $row
                        ->substr(471, 10)
                        ->trim(),
                    'Australia/Sydney'
                );

                if ($validTo->equalTo(Carbon::parse('9999-12-31', 'Australia/Sydney'))) {
                    $validTo = null;
                }

                $valid = $validFrom->isPast() && ($validTo === null || $validTo->isFuture());

                return new SuperannuationFund(
                    abn                   : $row
                        ->substr(0, 11)
                        ->trim(),

                    fundName              : $row
                        ->substr(12, 200)
                        ->trim(),

                    usi                   : $row
                        ->substr(213, 20)
                        ->trim(),

                    productName           : $row
                        ->substr(234, 200)
                        ->trim(),

                    restrictsContributions: $row
                        ->substr(435, 24)
                        ->trim()
                        ->exactly('Y'),

                    valid                 : $valid,
                    validFrom             : $validFrom,
                    validTo               : $validTo,
                );
            });
    }
}