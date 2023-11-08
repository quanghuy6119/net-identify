<?php
namespace App\Domain\Exceptions;

use App\Services\StatusCode;

class NotFoundException extends \Exception{

    private $statusCode;

    public function __construct($message = 'Data not found', $statusCode = StatusCode::NOT_FOUND_DATA) {
        $this->statusCode = $statusCode;
        parent::__construct($message);
    }

    /**
     * Get status code
     *
     * @return void
     */
    public function getStatusCode(){
        return $this->statusCode;
    }
}