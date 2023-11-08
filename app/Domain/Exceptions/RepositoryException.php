<?php
namespace App\Domain\Exceptions;


class RepositoryException extends \Exception{
    public function __construct($message){
        parent::__construct($message);
    }
}