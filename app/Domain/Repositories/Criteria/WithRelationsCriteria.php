<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;

class WithRelationsCriteria extends Criteria{
    private array $relations;
    public function __construct(array $relations = []) {
        $this->relations = $relations;
    }

    public function apply(Builder $query){
        if($this->relations != null && \count($this->relations) > 0){
            $query = $query->with($this->relations);
        }
        return $query;
    }
}