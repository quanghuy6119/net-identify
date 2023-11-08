<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;
use App\Utilities\Helpers\StringHelper;

class ILikeRelationOnManyCriteria extends Criteria{
    private $relation;
    private $columns = [];
    private $value = null;

    public function __construct($relation, $columns = [], $value) {
        $this->relation = $relation;
        $this->columns = $this->mapColumns($columns);
        $this->value = $value;
    }

    public function apply(Builder $query){
        $columns = $this->columns;
        $value = $this->value;
        if (empty($this->columns)) return $query;
        return $query->whereHas($this->relation, function (Builder $query) use($columns, $value) {
            $beginFlag = true;
            foreach ($columns as $col) {
                if ($beginFlag) {
                    $query->where($col, "ilike", "%".$value."%");
                    $beginFlag = false;
                } else {
                    $query->orWhere($col, "ilike", "%".$value."%");
                }
            }
        });
    }

    private function mapColumns(array $columns) {
        $newColumns = [];
        foreach ($columns as $col) {
            $newColumns[] = StringHelper::convertCamelToSnakeCase($col);
        }
        return $newColumns;
    }
}