<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Model as EloquentModel;

use App\Domain\Repositories\Criteria\Criteria;
use App\Domain\Adapters\EntityAdapterInterface;
use App\Domain\Repositories\Contracts\BaseRepositoryInterface;
use App\Domain\Entities\Entity;
use App\Domain\Exceptions\AdapterException;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Exceptions\DatabaseException;
use App\Domain\Exceptions\Exception;
use App\Utilities\Container\ContainerTrait;
use App\Utilities\Attributes\AttributeAccessException;

abstract class BaseRepository implements BaseRepositoryInterface
{
    use ContainerTrait;

    private DataManager $manager;

    private DataRetriever $retriever;

    function __construct(EloquentModel $model, EntityAdapterInterface $entityAdapter)
    {
        $this->manager = new DataManager($model, $entityAdapter);
        $this->retriever = new DataRetriever($model, $entityAdapter);
    }

    /**
     * Get by id
     *
     * @param mixed $id
     * @return Entity|null
     * @throws AdapterException
     */
    public function getById($id){
        return $this->retriever->getById($id);
    }

    /**
     * Get by id array
     *
     * @param array $ids
     * @return array a list of entities
     * @throws NotFoundException
     */
    public function getByIds(array $ids = []){
        return $this->retriever->getByIds($ids);
    }

    /**
     * Get data by apply criterias (default all)
     *
     * @param [type] $id
     * @return array|null
     * @throws AdapterException
     */
    public function get(){
        return $this->retriever->get();
    }
   
    /**
     * Get data by apply criterias (default all)
     *
     * @param [type] $id
     * @return array|null
     * @throws AdapterException
     */
    public function getAll(){
        return $this->retriever
            ->skipCriteria(true)->get();
    }

    /**
     * Find records
     *
     * @return void
     */
    public function find(?int $limit = 30){
        return $this->retriever->find($limit); 
    }

    /**
     * Create a new record
     *
     * @param Entity $entity
     * @return Entity 
     * @throws DatabaseException 
     * @throws AdapterException
     * @throws Exception
     */
    function create(Entity $entity){
        return $this->manager->create($entity);
    }

    /**
     * Update an entity by id
     *
     * @param Entity $entity
     * @return bool
     * @throws NotFoundException
     * @throws AdapterException
     */
    function update(Entity $entity){
        return $this->manager->update($entity); 
    }

      /**
     * Update a subset of attributes
     *
     * @param [type] $id
     * @param array $attributes atrributes of entity
     * @return bool
     * @throws NotFoundException
     * @throws DatabaseException
     * @throws AdapterException
     * @throws AttributeAccessException
     * @throws Exception
     */
   
     function updateAttributes($id, array $attributes){
        return $this->manager->updateAttributes($id, $attributes);
     }

    /**
     * Delete by id
     *
     * @param [type] $id
     * @return bool
     * @throws DatabaseException
     * @throws NotFoundException
     * @throws Exception
     */
    function deleteById($id){
        return $this->manager->deleteById($id);
    }

    /**
     * Push a criterial to collection
     *
     * @param Criteria $criteria
     * @return self
     */
    function pushCriteria(Criteria $criteria){
        $this->retriever->pushCriteria($criteria);
    }

    /**
     * Set the value of customEntityAdapter
     *
     * @return  self
     */ 
    public function withAdapter($customAdapter){
        $this->retriever->withAdapter($customAdapter);
        $this->manager->withAdapter($customAdapter);
        return $this;
    }

    /**
     * reset to default adapter
     *
     * @return  self
     */ 
    public function resetAdapter(){
        $this->retriever->resetAdapter();
        $this->manager->resetAdapter();
        return $this;
    }

    /**
     * reset critetias to empty
     *
     * @return  self
     */ 
    public function resetCriteria(){
        $this->retriever->resetCriteria();
        return $this;
    }

    /**
     * Get data by criteria 
     *
     * @param Criteria $criteria
     * @throws AdapterException
     * @return array
     */
    public function getByCriteria(Criteria $criteria){
        return $this->retriever->getByCriteria($criteria);
    }
}
