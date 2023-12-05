<?php

namespace Atlas\SuperFunds\Contracts;

interface Downloader
{
    public function download(): string;
}
