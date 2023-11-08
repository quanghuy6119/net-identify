<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

abstract class Criteria{
/**
     * Apply a this criteria to a query.
     *
     * @param Builder $query
     * @return Builder
     */
    abstract function apply(Builder $query);
}