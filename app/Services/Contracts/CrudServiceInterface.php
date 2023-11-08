<?php

namespace App\Services\Contracts;

use App\Domain\Entities\Entity;

/**
 * Crud interface for creating, reading , updating and deleting
 */
interface CrudServiceInterface{

    /**
     * Create a new record
     *
     * @param array $attributes
     * @return void
     * @throws InvalidInputException
     * @throws ServiceException
     */
    public function create(array $attributes);

    /**
     * Update a record by id
     *
     * @param int $id
     * @param array $attributes
     * @return bool
     * @throws InvalidInputException
     * @throws NotFoundException
     */
    public function update(int $id, array $attributes);

    /**
     * Delete a record by id
     *
     * @param int $id
     * @return bool
     * @throws ServiceException
     */
    public function delete(int $id);

    /**
     * Get a record by id
     *
     * @param int $id
     * @return Entity
     * @throws ServiceException
     */
    public function getById(int $id);

    /**
     * Get all records
     *
     * @return array
     * @throws ServiceException
     */
    public function getAll();
}
