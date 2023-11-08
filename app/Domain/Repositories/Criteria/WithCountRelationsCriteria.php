<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;

class WithCountRelationsCriteria extends Criteria{
    private array $relations;
    public function __construct(array $relations = []) {
        $this->relations = $relations;
    }

    public function apply(Builder $query){
        if($this->relations != null && \count($this->relations) > 0){
            $query = $query->withCount($this->relations);
        }
        return $query;
    }
}