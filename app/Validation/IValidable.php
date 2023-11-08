<?php

namespace App\Validation;

interface IValidable{
    /**
     * With
     *
     * @param  array $input
     * @return void
     */
    public function with(array $input);
        
    /**
     * Check the validity of the input
     *
     * @return bool
     */
    public function fails() : bool;
        
    /**
     * Passes
     *
     * @return bool
     */
    public function passes() : bool;
    
    /**
     * Get errors returned
     *
     * @return array
     */
    public function errors();

    /**
     * Ignore rule of id
     *
     * @param  int $input
     * @return array
     */
    public function ignore(int $id);
}

