<?php

namespace App\Domain\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Criteria\Criteria;

class BetweenDateTimeCriteria extends Criteria
{

    private $attribute = null;
    private $fromDate = null;
    private $toDate = null;

    public function __construct($attribute, $fromDate, $toDate)
    {
        $this->attribute = $attribute;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function apply(Builder $query)
    {
        $query->whereDate($this->attribute,'>=', $this->fromDate)->whereDate($this->attribute, '<=' , $this->toDate);
        return $query;
    }
}
