<?php

namespace App\Domain\Repositories\Contracts;

use App\Domain\Entities\Entity;
use App\Domain\Exceptions\DatabaseException;
use App\Domain\Repositories\Criteria\Criteria;
use App\Domain\Exceptions\Exception;
/**
 *
 */
interface BaseRepositoryInterface{
    /**
     * Get by id
     *
     * @param [type] $id
     * @return Entity|null
     * @throws AdapterException
     */
    public function getById($id);

    /**
     * Get by id array
     *
     * @param [type] $ids
     * @return array
     * @throws NotFoundException
     */
    public function getByIds(array $ids = []);

    /**
     * Get data
     *
     * @param [type] $id
     * @return array|null
     * @throws AdapterException
     */
    public function get();

    /**
     * Get all records
     *
     * @return array|null
     * @throws AdapterException
     */
    public function getAll();

    /**
     * Find records
     *
     * @return void
     */
    public function find();

    /**
     * Create a new record
     *
     * @param Entity $entity
     * @return Entity
     * @throws DatabaseException
     * @throws AdapterException
     * @throws Exception
     */
    public function create(Entity $entity);

    /**
     * Update an entity by id
     *
     * @param Entity $entity
     * @return bool
     * @throws NotFoundException
     * @throws AdapterException
     */
    public function update(Entity $entity);

    /**
     * Update a subset of attributes
     *
     * @param [type] $id
     * @param array $attributes attributes of entity
     * @return bool
     * @throws NotFoundException
     * @throws DatabaseException
     * @throws AdapterException
     * @throws AttributeAccessException
     * @throws Exception
     */
    public function updateAttributes($id, array $attributes);

    /**
     * Delete by id
     *
     * @param [type] $id
     * @return bool
     * @throws DatabaseException
     * @throws NotFoundException
     * @throws Exception
     */
    public function delete($id);


    /**
     * Push a criterial to collection
     *
     * @param Criteria $criteria
     * @return self
     */
    public function pushCriteria(Criteria $criteria);

    /**
     * Set the value of customEntityAdapter
     *
     * @return  self
     */
    public function withAdapter($customAdapter);

    /**
     * reset to default adapter
     *
     * @return  self
     */
    public function resetAdapter();

    /**
     * reset to default adapter
     *
     * @return  self
     */
    public function resetCriteria();

    /**
     * Get data by
     *
     * @param Criteria $criteria
     * @throws AdapterException
     * @return array
     */
    public function getByCriteria(Criteria $criteria);
}
