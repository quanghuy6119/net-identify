<?php

namespace App\Domain\Repositories\Criteria\Traits;
use App\Domain\Repositories\Criteria\Criteria;

trait CollectionTrait{
    /**
     * Criteria collection
     *
     * @var array
     */
    protected array $criteriaCollection = [];

    public function __construct(Criteria ...$criteria){
        $this->criteriaCollection = $criteria;
    }
}