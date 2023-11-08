<?php

namespace App\Domain\Exceptions;

use App\Services\StatusCode;

/**
 * Exception for error not have permission
 */
class PermissionException extends \Exception
{
    private $statusCode;

    public function __construct($message = "You don't have permission", $statusCode = StatusCode::UNAUTHORIZED)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
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