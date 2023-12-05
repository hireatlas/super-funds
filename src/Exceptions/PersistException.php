<?php

namespace Atlas\SuperFunds\Exceptions;

use Throwable;

class PersistException extends \Exception
{
    public function __construct(
        string $message = 'There was an error while persisting the list of super funds.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
