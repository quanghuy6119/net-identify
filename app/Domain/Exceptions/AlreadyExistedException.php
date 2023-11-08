<?php

namespace App\Domain\Exceptions;

/**
 * A common exception for the record already existed
 */
class AlreadyExistedException extends \Exception
{

    private $errors;
    private $statusCode;

    public function __construct($message, $statusCode, $errors = null)
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
