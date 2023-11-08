<?php

namespace App\Domain\Exceptions;

use Exception;

class AdapterException extends Exception{

    public function __construct($message, int $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}