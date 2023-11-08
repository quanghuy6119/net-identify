<?php

namespace App\Utilities\Serializer\Exceptions;

class SerializerException extends \Exception{
    public function __construct($message){
        parent::__construct($message);
    }
}