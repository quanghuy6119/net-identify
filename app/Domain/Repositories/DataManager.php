<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use App\Domain\Entities\Entity;
use App\Domain\Adapters\EntityAdapterInterface as EntityAdapter;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Exceptions\DatabaseException;
use App\Domain\Exceptions\Exception;
use App\Domain\Exceptions\CanNotMakeQueryException;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Exceptions\AdapterException;
use App\Domain\Repositories\Criteria\Criteria;
use App\Domain\Repositories\Traits\ManyUpsert;
use App\Domain\Repositories\Traits\WithAdapter;

/**
 * Class DataManager
 *
 * This class provides methods to manage data in the database.
 * @author Fox
 * Logs:
 *      - Implemented logic codes for update, updateAttributes, create, delete methods
 *      - Edit deleteById(): Add 2 params getCode(), $ex to DatabaseException constructor 
 * Updated at: 2023-06-19
 *      - (BaoHoa) Edit logics in update method: skip updating createdAt (ln96), fix creating new model (ln 100)
 *      - Edit updateAttributes method: return $rs->update($model->toArray()) (BaoHoa - 07/11)
 */
class DataManager
{
    use WithAdapter, ManyUpsert;

    private $model;

    /**
     * DataManager constructor.
     *
     * @param Model $model The Eloquent model instance.
     * @param EntityAdapter $adapter The entity adapter used to convert entities to Eloquent models and vice versa.
     */
    public function __construct(Model $model, EntityAdapter $adapter)
    {
        $this->defaultAdapter = $adapter;
        $this->model = $model;
    }

    /**
     * Creates a new query builder instance of the model.
     *
     * @return Builder The query builder instance.
     * @throws CanNotMakeQueryException If an exception occurs while creating the query builder.
     */
    public function makeQuery()
    {
        try {
            return $this->model->newQuery();
        } catch (\Throwable $ex) {
            throw new CanNotMakeQueryException("Can't make a query", $ex->getCode(), $ex);
        }
    }

    /**
     * Creates a new record in the database based on the provided entity.
     *
     * @param Entity $entity The entity to be created.
     * @return Entity The created entity.
     * @throws DatabaseException  If an exception occurs while saving data to database.
     * @throws AdapterException If an exception occurs while converting the entity to an Eloquent model.
     * @throws Exception If the entity adapter is null.
     */
    public function create(Entity $entity)
    {
        throw_if(is_null($this->adapter()), Exception::class, ["message" => "Entity adapter is null"]);
      
        $model = $this->adapter()->toEloquent($entity);
        try {
            $model->save();
        } catch (\PDOException $ex) {
            throw new DatabaseException($ex->getMessage(), $ex->getCode(), $ex);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
        return $this->adapter()->toEntity($model);
    }

    /**
     * Updates an existing entity in the database based on the provided entity.
     *
     * @param Entity $entity The entity to be updated.
     * @return bool True if the update is successful, false otherwise.
     * @throws NotFoundException If the record with the entity's ID is not found in the database.
     * @throws DatabaseException If a database exception occurs during the update.
     * @throws AdapterException If an exception occurs while converting the entity to an Eloquent model.
     * @throws Exception If the entity's ID is null.
     */
    public function update(Entity $entity)
    {
        $id = $entity->getId();
        throw_if(is_null($id), Exception::class, ["message" => "Got null id value from entity"]);
        $query = $this->makeQuery();
        $rs = $query->find($id);
        if(!$rs) throw new NotFoundException("Couldn't find any record that matches id = @{$id}");
        // skip to update created at
        if($rs->timestamps) $entity->setAttribute("createdAt",  $rs->created_at);
        // new model
        $model = $this->adapter()->toEloquent($entity);
        // fill converted data to old model
        $rs->fill($model->toArray());
        return $rs->save();
    }

    /**
     * Updates a subset of attributes of an entity in the database based on the provided ID and attributes.
     *
     * @param mixed $id The ID of the record to be updated.
     * @param array $attributes The attributes to be updated.
     * @return bool True if the update is successful, false otherwise.
     * @throws NotFoundException If the record with the provided ID is not found in the database.
     * @throws DatabaseException If a database exception occurs during the update.
     * @throws AdapterException If an exception occurs while converting the entity to an Eloquent model.
     * @throws AttributeAccessException If an exception occurs while setting the attributes on the entity.
     * @throws Exception If any other exception occurs during the update.
     */
    public function updateAttributes($id, array $attributes)
    {
        $query = $this->makeQuery();
        $rs = $query->find($id);
        if (!$rs) throw new NotFoundException("Couldn't find any record that matches with id = {$id}");
        $entity = $this->adapter()->toEntity($rs);

        $entity->setAttributes($attributes);
        try {
            $model = $this->adapter()->toEloquent($entity);

            return $rs->update($model->toArray());
        } catch (QueryException $ex) {
            throw new DatabaseException("Database exception: " . $ex->getMessage());
        } catch (AdapterException $ex) {
            throw new AdapterException("Can't convert entity to eloquent.");
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * Deletes a record from the database based on the provided ID.
     *
     * @param mixed $id The ID of the record to be deleted.
     * @return bool True if the delete is successful, false otherwise.
     * @throws NotFoundException If the record with the provided ID is not found in the database.
     * @throws DatabaseException If a database exception occurs during the delete.
     * @throws Exception If any other exception occurs during the delete.
     */
    public function deleteById($id)
    {
        $query = $this->makeQuery();
        $model = $query->find($id);
        if (!$model) throw new NotFoundException("The record does not exist");
        try {
            return $model->delete($id);
        } catch (QueryException $ex) {
            throw new DatabaseException("Database exception: " . $ex->getMessage(), $ex->getCode(), $ex);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

     /**
     * Deletes records from the database based on criteria
     *
     * @param mixed $id The ID of the record to be deleted.
     * @return bool True if the delete is successful, false otherwise.
     * @throws NotFoundException If the record with the provided ID is not found in the database.
     * @throws DatabaseException If a database exception occurs during the delete.
     * @throws Exception If any other exception occurs during the delete.
     */
    public function deleteByCriteria(Criteria $criteria)
    {
        $query = $this->makeQuery();
        $query = $criteria->apply($query);
        return $query->delete();
    }
}
