<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;

class OrderByRelationCriteria extends Criteria{
     
    private string $table;
    private string $distinctColumn;
    private string $relationTable;
    private string $matchColumn;
    private string $matchRelationColumn;
    private array $attributes;
    private string $orderByColumn;

    public function __construct(string $table, string $distinctColumn, string $relationTable, 
            string $matchColumn, string $matchRelationColumn, 
            array $attributes, string $orderByColumn) {
        $this->table = $table;
        $this->distinctColumn = $distinctColumn;
        $this->relationTable = $relationTable;
        $this->matchColumn = $matchColumn;
        $this->matchRelationColumn = $matchRelationColumn;
        $this->attributes = $attributes;
        $this->orderByColumn = $orderByColumn;
    }

    public function apply(Builder $query){
        $query->leftJoin($this->relationTable . ' as other', $this->table.'.'.$this->matchColumn, '=', 
                'other.' . $this->matchRelationColumn)
            ->select('other.' . $this->orderByColumn, ...$this->attributes)
            ->distinct($this->distinctColumn);
        return $query;
    }

    /**
     * Add table prefix to attributes
     *
     * @param array $attributes
     * @param string $prefix
     * @return array
     */
    private function addPrefix(array $attributes, string $prefix) {
        $rs = [];
        foreach ($attributes as $attr) {
            $rs[] = $prefix . '.' . $attr;
        }
        return $rs;
    }
}