<?php
namespace App\Domain\Exceptions;


class UploadFailException extends \Exception{
    public function __construct($message){
        parent::__construct($message);
    }
}