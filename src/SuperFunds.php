<?php

namespace Atlas\SuperFunds;

use Atlas\SuperFunds\Contracts\Downloader;
use Atlas\SuperFunds\Contracts\Parser;
use Atlas\SuperFunds\Contracts\Persister;
use Atlas\SuperFunds\Models\SuperFund;
use Illuminate\Support\Collection;

class SuperFunds
{
    /**
     * Indicates if the package migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * The super fund model class name.
     *
     * @var string
     */
    public static $model = SuperFund::class;

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
     * Set the super fund model class name.
     */
    public static function useModel(string $superFundModel): void
    {
        static::$model = $superFundModel;
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
