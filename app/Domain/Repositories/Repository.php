<?php

namespace App\Domain\Repositories;
use App\Utilities\Container\ContainerTrait;

/**
 * Repository
 * 
 * This class is base class for all of repositories.
 * @author Fox
 * Logs: 
 *      - Register ContainerTrait
 * Updated at: 2023-06-19
 */

abstract class Repository
{
    use ContainerTrait;

    protected $model;

    public function __construct($model = null)
    {
        $this->setModel($model);
    }

    /**
     * Set value to model
     * @return self
     */
    protected function setModel($model){
        $this->model = $model;
        return $this;
    }

    /**
     * Get model value
     */
    protected function getModel(){
        return $this->model;
    }
}
