<?php
namespace App\Domain\Entities;

class ModelMappingException extends \Exception{
    public $prop;
    public function __construct(?string $prop = null) {
        $this->prop = $prop;
    }
}