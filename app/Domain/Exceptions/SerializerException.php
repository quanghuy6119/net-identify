<?php

namespace App\Domain\Exceptions;

use App\Services\StatusCode;

class SerializerException extends \Exception
{
    public function __construct($message, $code = StatusCode::INTERNAL_SERVER_ERROR, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
