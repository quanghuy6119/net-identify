<?php

namespace App\Domain\Exceptions;

use App\Services\StatusCode;

/**
 * Exception for error related to invalid input validation
 */
class InvalidInputException extends \Exception
{

    private $errors;

    private $statusCode;

    public function __construct($errors, $statusCode = StatusCode::INVALID_INPUT, $message = "invalid input")
    {
        parent::__construct($message);
        $this->errors = $errors;
        $this->statusCode = $statusCode;
    }

    /**
     * Get error
     *
     * @return void
     */
    public function getError()
    {
        return $this->errors;
    }

    /**
     * Get status code
     *
     * @return void
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
