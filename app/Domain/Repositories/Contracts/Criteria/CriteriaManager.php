<?php
//merged
namespace App\Domain\Repositories\Contracts\Criteria;
use App\Domain\Repositories\Criteria\Criteria;

interface CriteriaManager{

    /**
     * Skip criterial
     *
     * @param boolean $status
     */
    public function skipCriteria($status = true);

    /**
     * Get data by a criteria
     * @return mixed
     * @param Criteria $criteria
     */
    function getByCriteria(Criteria $criteria);
    /**
     * Push a criterial to collection
     *
     * @param Criteria $criteria
     * @return mixed
     */
    function pushCriteria(Criteria $criteria);

    /**
     * Apply all of criterial
     *
     * @return mixed
     */
    function applyCriteria();

    /**
     * Reset criteria
     *
     * @return mixed
     */
    function resetCriteria();
}
