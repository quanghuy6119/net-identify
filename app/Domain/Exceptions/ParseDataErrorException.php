<?php

namespace App\Domain\Exceptions;

use Exception;

class ParseDataErrorException extends Exception{
    
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
