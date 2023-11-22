<?php

namespace Atlas\LaravelAustralianSuperannuationFunds\Contracts;

interface Downloader
{
    public function download(): string;
}