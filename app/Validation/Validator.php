<?php

namespace App\Validation;

use Illuminate\Validation\Factory;
use Illuminate\Support\MessageBag;

class Validator{
    /**
     * Validator
     *
     * @var mixed
     */
    protected $validator;
    /**
     * Data need to be validated
     *
     * @var array
     */
    protected array $data;
        
    /**
     * Validation rules
     *
     * @var array
     */
    protected array $rules = array();
        
    /**
     * Validation errors
     *
     * @var array
     */
    protected MessageBag $errors;

    /**
     * Custom Message
     *
     * @var array
     */
    protected array $customMessage = array();

    public function __construct(Factory $validator){
        $this->validator = $validator;
    }
    
    /**
     * Set data for validation
     *
     * @param  mixed $data
     * @return Factory
     */
    public function with(array $data){
        $this->data = $data;
        return $this->validator;
    }    
    /**
     * Get errors
     *
     * @return void
     */
    public function errors(){
        return $this->errors;
    }
        
    /**
     * Check the validity of the data
     *
     * @return boolean
     */
    public function fails(): bool{
        $validator = $this->validator->make($this->data, $this->rules, $this->customMessage);
        
        if($validator->fails()){
            $this->errors = $validator->messages();
            return true;
        }
        return false;
    }
     /**
     * Check the validity of the data
     *
     * @return boolean
     */
    public function passes(): bool{
        $validator = $this->validator->make($this->data, $this->rules, $this->customMessage);
        
        if($validator->fails()){
            $this->errors = $validator->messages();
            return false;
        }
        return true;
    }

    protected function appendRule(string $attribute, string $rule) {
        $this->rules[$attribute] =  $this->rules[$attribute].'|'.$rule;
    }

    protected function replaceRule(string $attribute, string $rule) {
        $this->rules[$attribute] =  $this->rules[$attribute] = $rule;
    }

    public function ignore(int $id){
    }

    protected function removeRule(string $attribute) {
        $this->rules[$attribute] =  '';
    }
}