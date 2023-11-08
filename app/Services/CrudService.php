<?php

namespace App\Services;

use App\Domain\Entities\Entity;
use App\Domain\Repositories\Contracts\BaseRepositoryInterface;
use App\Services\Contracts\CrudServiceInterface;
use App\Validation\Action;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Exceptions\InvalidInputException;
use App\Domain\Exceptions\ServiceException;
use App\Validation\IValidable;

/**
 * This class supports basic features for 
 * CRUD(Create Read Update Delete).
 */
abstract class CrudService extends Service implements CrudServiceInterface
{
    protected BaseRepositoryInterface $repository;

    /**
     * Create a new record
     *
     * @param array $attributes
     * @throws InvalidInputException
     * @throws ServiceException
     */
    public abstract function create(array $attributes);

    /**
     * Update a record by id
     *
     * @param int $id
     * @param array $attributes
     * @return bool
     * @throws InvalidInputException
     * @throws NotFoundException
     */
    public function update(int $id, array $attributes)
    {
        // Validate for update action
        $validator = $this->getValidator(Action::UPDATE);
        $validator->ignore($id);
        $validator->with($attributes);
        if ($validator->fails()) throw new InvalidInputException($validator->errors());
        
        return $this->repository->updateOnly($id, $attributes);
    }

    /**
     * Delete a record by id
     *
     * @param int $id
     * @return bool
     * @throws ServiceException
     */
    public function delete(int $id)
    {
        $repository = $this->getRepository();

        $rs = $repository->delete($id);
        if (!$rs) throw new ServiceException("Cannot delete");
        return $rs;
    }

    /**
     * Get a record by id
     *
     * @param int $id
     * @return Entity
     * @throws ServiceException
     */
    public function getById(int $id)
    {
        return $this->getRepository()->getById($id);
    }

    /**
     * Get all records
     *
     * @return array
     * @throws ServiceException
     */
    public function getAll()
    {
        $repository = $this->getRepository();
        return $repository->skipCriteria()->getAll();
    }

    /**
     * Get repository
     *
     * @return BaseRepositoryInterface
     * @throws ServiceException
     */
    private function getRepository() : BaseRepositoryInterface
    {
        if (!$this->repository) throw new ServiceException("Repository can't be null");
        return $this->repository;
    }

    /**
     * Set repository
     *
     * @param BaseRepositoryInterface $repository
     * @return self
     * @throws ServiceException
     */
    protected function setRepository(BaseRepositoryInterface $repository) : self
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Get validator
     *
     * @param string $action
     * @return IValidable
     * @throws ServiceException
     */
    protected abstract function getValidator(string $action) : IValidable;
}
