<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;

class IncludeInCriteria extends Criteria{
     
    private string $attribute;
    private array $value;

    public function __construct(string $attribute, array $value) {
        $this->attribute = $attribute;
        $this->value = is_null($value) ? [] : $value;
    }

    public function apply(Builder $query){
        $query->whereIn($this->attribute, $this->value);
        return $query;
    }
}