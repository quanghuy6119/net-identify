<?php
namespace App\Domain\Exceptions;

/**
 * A common exception for the service layer
 */
class ServiceException extends \Exception{

    public function __construct($message) {
        parent::__construct($message);
    }
}