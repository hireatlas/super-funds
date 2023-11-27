<?php

namespace Atlas\LaravelAustralianSuperannuationFunds\Exceptions;

use Throwable;

class PersistException extends \Exception
{
    public function __construct(
        string $message = 'There was an error while persisting the list of superannuation funds.',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
