<?php

namespace Atlas\LaravelAustralianSuperannuationFunds;

use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Parser as ParserContract;
use Atlas\LaravelAustralianSuperannuationFunds\DTOs\SuperannuationFundDTO;
use Atlas\LaravelAustralianSuperannuationFunds\Exceptions\ParseException;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class Parser implements ParserContract
{
    /**
     * @link https://superfundlookup.gov.au/Tools/DownloadUsiList
     */
    public function parse(string $file): Collection
    {
        try {
            return (new Stringable($file))
                ->replace(
                    [
                        "\r\n",
                        "\r",
                    ],
                    "\n"
                )
                ->explode("\n")
                ->filter(function (string $row) {
                    // Filter out any rows that are not 481 characters long (footers)
                    if (strlen($row) !== 481) {
                        return false;
                    }

                    // Filter out any known strings that should not be parsed (headers)
                    $headerRows = [
                        'ABN         FundName                                                                                                                                                                                                 USI                  ProductName                                                                                                                                                                                              ContributionRestrictions From       To        ',
                        '----------- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -------------------- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- ------------------------ ---------- ----------',
                    ];

                    return ! in_array($row, $headerRows);
                })
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

                    return new SuperannuationFundDTO(
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
        } catch (\Throwable|\Exception $exception) {
            throw new ParseException(previous: $exception);
        }
    }
}
