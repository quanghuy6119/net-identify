<?php

namespace App\Domain\Repositories\Criteria\Traits;
use App\Domain\Repositories\Criteria\Criteria;
use Illuminate\Database\Eloquent\Builder;

/**
 * @author Fox
 *
 */
trait QueryByCriteriaStrategy
{
    use CollectionTrait;

    /**
     * To skip to apply criteria
     */
    protected $skipCriteria = false;

    /**
     * to create query to connect to db
     */
    public Builder $query;

    /**
     * make a query builder
     *
     * @return Builder
     */
    public abstract function makeQuery();

    /**
     * Apply all of criteria
     *
     * @return self
     */
    function applyCriteria()
    {
        $this->query = $this->makeQuery();
        // doesn't apply criteria
        if ($this->skipCriteria === true) return $this;
        // apply criterias to the query
        foreach ($this->criteriaCollection as $criteria) {
            $this->query = $criteria->apply($this->query, $this);
        }
        return $this;
    }

    /**
     * Skip criterial
     *
     * @param boolean $status
     * @return self
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * Push a criterial to collection
     *
     * @param Criteria $criteria
     * @return self
     */
    function pushCriteria(Criteria $criteria)
    {
        if (!$criteria) return $this;
        $this->criteriaCollection[] = $criteria;
        return $this;
    }

    /**
     * Reset all criteria of
     * @return self
     */
    public function resetCriteria()
    {
        $this->criteriaCollection = [];
        return $this;
    }
}
