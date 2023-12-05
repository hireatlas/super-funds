<?php

namespace Atlas\SuperFunds\DTOs;

class SuperFundDTO
{
    public function __construct(
        public readonly string $abn,
        public readonly string $fundName,
        public readonly string $usi,
        public readonly string $productName,
        public readonly bool $restrictsContributions,
        public readonly bool $valid,
        public readonly \DateTimeInterface $validFrom,
        public readonly ?\DateTimeInterface $validTo = null,
    ) {
        //
    }
}
