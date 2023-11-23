<?php

namespace Atlas\LaravelAustralianSuperannuationFunds\DTOs;

readonly class SuperannuationFund
{
    public function __construct(
        public string $abn,
        public string $fundName,
        public string $usi,
        public string $productName,
        public bool $restrictsContributions,
        public bool $valid,
        public \DateTimeInterface $validFrom,
        public ?\DateTimeInterface $validTo = null,
    ) {
        //
    }
}
