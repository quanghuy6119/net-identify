<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;

class ILikeCriteria extends Criteria{
     
    private $attribute = null;
    private $value = null;

    public function __construct($attribute, $value) {
        $this->attribute = $attribute;
        $this->value = $value;
    }

    public function apply(Builder $query){
        $query->where($this->attribute,"ilike","%". $this->value ."%");
        return $query;
    }
}