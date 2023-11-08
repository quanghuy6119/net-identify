<?php

namespace App\Domain\Exceptions;

use Exception;

class ArgumentNullException extends Exception{
    
    private $name;

    public function __construct($name, $message, int $code = 0, $previous = null)
    {
        $this->name = $name;
        parent::__construct($message, $code, $previous);
    }

    public function getName(){
        return $this->name;
    }
    
    /**
     * Get the string representation of the exception.
     *
     * @return string The string representation of the exception.
     */
    public function __toString()
    {
        return __CLASS__ . ": {$this->getName()} ".": [{$this->code}]: {$this->message}\n";
    }
}
