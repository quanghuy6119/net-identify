<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;

class IncludeInRelationCriteria extends Criteria{
     
    private string $relation;
    private string $attribute;
    private array $value;

    public function __construct(string $relation, string $attribute, array $value) {
        $this->relation = $relation;
        $this->attribute = $attribute;
        $this->value = is_null($value) ? [] : $value;
    }

    public function apply(Builder $query){
        $query->with($this->relation)->whereHas($this->relation, function(Builder $query) {
            $query->whereIn($this->attribute, $this->value);
        });
        return $query;
    }
}