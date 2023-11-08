<?php
namespace App\Domain\Exceptions;


/**
 * A attribute error exception when 
 * having any errors occurred on converting an array to entity
 */
class ArgumentException extends \Exception{
    private array $attribute;

    public function __construct($message, ...$attribute) {
        parent::__construct($message);
        $this->attribute = $attribute;
    }
    /**
     * Get error
     *
     * @return void
     */
    public function getErrorAttr(){
        return $this->attribute;
    }
}