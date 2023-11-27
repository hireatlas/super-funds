<?php

namespace Atlas\LaravelAustralianSuperannuationFunds;

use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Downloader;
use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Parser;
use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Persister;
use Atlas\LaravelAustralianSuperannuationFunds\Models\SuperannuationFund;
use Illuminate\Support\Collection;

class SuperannuationFunds
{
    /**
     * Indicates if the package migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * The superannuation fund model class name.
     *
     * @var string
     */
    public static $model = SuperannuationFund::class;

    public function __construct(
        private Downloader $downloader,
        private Parser $parser,
        private Persister $persister
    ) {
        //
    }

    /**
     * Configure the package to not register its migrations.
     */
    public static function ignoreMigrations(): void
    {
        static::$runsMigrations = false;
    }

    /**
     * Set the superannuation fund model class name.
     */
    public static function useModel(string $superannuationFundModel): void
    {
        static::$model = $superannuationFundModel;
    }

    public function fetch(): Collection
    {
        $file = $this->downloader->download();

        return $this->parser->parse($file);
    }

    public function persist(): Collection
    {
        return $this->persister->persist($this->fetch());
    }
}
