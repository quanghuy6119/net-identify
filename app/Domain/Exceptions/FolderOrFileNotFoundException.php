<?php
namespace App\Domain\Exceptions;


class FolderOrFileNotFoundException extends \Exception{
    public function __construct($message){
        parent::__construct($message);
    }
}