<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;
use App\Utilities\Helpers\StringHelper;

class OrderByCriteria extends Criteria{
    private $columns = null;
    private $directions = null;

    public function __construct(array $columns = [], array $directions = []) {
        $this->columns = $this->mapColumns($columns);
        $this->directions = $directions;
    }

    public function apply(Builder $query){
        foreach ($this->columns as $i => $col) {
            $query->orderBy($col, $this->directions[$i]);
        }
        return $query;
    }

    private function mapColumns(array $columns = []) {
        $newColumns = [];
        foreach ($columns as $col) {
            $newColumns[] = StringHelper::convertCamelToSnakeCase($col);
        }
        return $newColumns;
    }
}