<?php
namespace App\Domain\Repositories\Traits;

use App\Domain\Exceptions\ArgumentNullException;
use App\Domain\Exceptions\DatabaseException;
use App\Domain\Exceptions\Exception;
use App\Domain\UnitOfWork\UnitOfWorkTrait;
use App\Utilities\Helpers\EntitiesHelper;
use Illuminate\Database\QueryException;

trait ManyUpsert {

    use UnitOfWorkTrait;
    /**
     *  @return \Illuminate\Database\Eloquent\Builder
     */
    protected abstract function makeQuery();

    protected abstract function adapter();
    
    /**
     * To create or update many entities
     *
     * @throws DatabaseException If has errors occurred during updating to database
     * @throws Exception If has errors during updating
     * @return int
     */
    public function upsertMany(array $entities = [])
    {
        if(count($entities) === 0) throw new ArgumentNullException('entities', "Entities array is empty");
        $this->begin();
        try {
            // Get entities that should be created
            $newEntities = EntitiesHelper::filterWithIncludeIn($entities, [null], "id");
            $countNew = count($newEntities);
            if($countNew > 0) $this->upsert($newEntities);
            // Get entities that should be updated
            $updatedEntities = EntitiesHelper::diff($entities, [null], "id");
            $countUpdate = count($updatedEntities); 
            if($countUpdate > 0) $this->upsert($updatedEntities);
            // commit
            $this->commit();
            return $countUpdate + $countNew; 
        } catch (QueryException $ex) {
            $this->rollback();
            throw new DatabaseException("Database exception: " . $ex->getMessage(), $ex->getCode(), $ex);
        } catch (\Exception $ex) {
            $this->rollback();
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Upsert method
     *
     * @param array $entities array of entities to be created or updated
     * @return void
     */
    private function upsert($entities)
    {
        if (count($entities) > 0) {
            $models = $this->toEloquentArray($entities); 
            $data = array_map(fn($model) => $model->getAttributes(), $models);
            $data = $this->removeIdIfNull($data);
            $this->model->upsert($data, ['id'], $this->model->getFillable());
        }
    }

    /**
     * Remove id if null
     *
     * @param array $arrayData
     * @return array
     */
    private function removeIdIfNull(array $arrayData)
    {
        $results = [];
        foreach ($arrayData as $data) {
            $results[] = is_null($data["id"] ?? null) ? array_diff_key($data, ['id' => null]) : $data;
        }
        return $results;
    }

    /**
     * To convert an array of entities to an array of eloquent models
     *
     * @param array $entities
     * @return array
     */
    private function toEloquentArray(array $entities)
    {
        $eloquentArray = [];
        foreach ($entities as $entity) {
            $eloquent = $this->adapter()->toNewEloquent($entity);
            $eloquentArray[] = $eloquent;
        }
        return $eloquentArray;
    }
}