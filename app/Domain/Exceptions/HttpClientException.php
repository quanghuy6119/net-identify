<?php

namespace App\Domain\Exceptions;

use App\Utilities\Helpers\JsonHelper;

/**
 * A common exception for the http client
 */
class HttpClientException extends \Exception
{
    private $errors;
    private $statusCode;
    private $httpStatus;

    public function __construct(\Psr\Http\Message\ResponseInterface $res)
    {
        $body = JsonHelper::parseBody($res);
        parent::__construct($body['message']);
        $this->errors = $body['error'];
        $this->statusCode = $body['code'];
        $this->httpStatus = $res->getStatusCode();
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

    /**
     * Get http status
     *
     * @return void
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }
}
