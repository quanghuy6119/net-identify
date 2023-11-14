<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Adapters\EntityAdapterInterface as EntityAdapter;
use App\Domain\Repositories\Criteria\Traits\QueryByCriteriaStrategy;
use App\Domain\Exceptions\AdapterException;
use App\Domain\Entities\PaginatingAggregate;
use App\Domain\Exceptions\CanNotMakeQueryException;
use App\Domain\Repositories\Criteria\Criteria;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Repositories\Contracts\Criteria\CriteriaManager;
use App\Domain\Repositories\Traits\WithAdapter;
use Illuminate\Support\Collection;
/**
 * Class DataRetriever
 *
 * This class is responsible for retrieving data from the database using various criteria and adapters.
 */
class DataRetriever implements CriteriaManager{

    use QueryByCriteriaStrategy, WithAdapter;

    private bool $skipConversion = false;

    /**
     * @var Model The Eloquent model instance.
     */
    private $model;

    /**
     * DataRetriever constructor.
     *
     * @param Model $model The Eloquent model instance.
     * @param EntityAdapter $defaultAdapter The default adapter for converting models to entities.
     */
    public function __construct(Model $model, EntityAdapter $defaultAdapter)
    {
        $this->defaultAdapter = $defaultAdapter;
        $this->model = $model;
    }
    
    /**
     * Creates a new query builder instance of the model.
     *
     * @return Builder The query builder instance.
     * @throws CanNotMakeQueryException If an exception occurs while creating the query builder.
     */
    public function makeQuery(): Builder
    {
        try {
            return $this->model->newQuery();
        } catch (\Throwable $ex) {
            throw new CanNotMakeQueryException("Can't make a query", $ex->getCode(), $ex);
        }
    }
   
    /**
     * Retrieves all records from the database, applying any defined criteria, and converts them to entities.
     *
     * @return array|Collection An array of entities.
     * @throws AdapterException If an exception occurs while converting the models to entities.
     */
    public function get()
    {
        $this->applyCriteria();
        $data = $this->query->get();
        $this->resetCriteria();
        return $this->convertToEntities($data);
    }

    /**
     * Retrieves a record by its ID from the database, applying any defined criteria, and converts it to an entity.
     *
     * @param mixed $id The ID of the record to retrieve.
     * @return mixed|null The entity corresponding to the record, or null if the record is not found.
     * @throws AdapterException If an exception occurs while converting the model to an entity.
     */
    public function getById($id){
        $this->applyCriteria();
        $result = $this->query->find($id);
        $this->resetCriteria();
        if(!$result) return null;
        try {
            return $this->adapter()->toEntity($result);
        } catch (\Throwable $th) {
            throw new AdapterException("Can't convert to entity", $th->getCode(), $th);
        }
    }

    /**
     * Retrieves all records from the database, applying any defined criteria, and converts them to entities.
     *
     * @return array An array of entities.
     * @throws AdapterException If an exception occurs while converting the models to entities.
     */
    public function getByCriteria(Criteria $criteria): array
    {
        $query = $this->makeQuery();
        // apply criteria
        $query = $criteria->apply($query);
        // get data and convert to entities
        $results = $query->get();
        return $this->convertToEntities($results);
    }

    /**
     * Retrieves multiple records by their IDs from the database, applying any defined criteria, and converts them to entities.
     *
     * @param array $ids The IDs of the records to retrieve.
     * @return array|null An array of entities corresponding to the records, or null if no records are found.
     * @throws AdapterException If an exception occurs while converting the models to entities.
     */
    public function getByIds(array $ids = []){
        $this->applyCriteria();
        $results = $this->query->find($ids);
        $this->resetCriteria();
        if($results->isEmpty()) return null;
        return $this->convertToEntities($results);
    }

    /**
     * Counts the number of records in the database, applying any defined criteria.
     *
     * @return int The total number of records.
     */
    public function count()
    {
        $this->applyCriteria();
        $total = $this->query->count();
        $this->resetCriteria();
        return $total;
    }

     /**
     * Finds records in the database, applying any defined criteria and pagination.
     *
     * @param int|null $limit The number of records to retrieve per page (null for no pagination).
     * @return PaginatingAggregate The paginated result as a PaginatingAggregate instance.
     * @throws AdapterException If an exception occurs while converting the models to entities.
     */
    public function find(?int $limit = 30){
        $this->applyCriteria();
        if ($limit == 0) {
            $rs = $this->query->get();
            // current page
            $page = isset($_GET['page']) ? \intval($_GET['page']) : 1;
            // return [] if the current page is greater than 1
            $count = \count($rs);
            $entities = $page > 1 ? [] : $this->convertToEntities($rs);
            return new PaginatingAggregate($entities,  $count,  $count, $page);
        } else {
            $paginator = $this->query->paginate($limit);
            return $this->convertToEntityPaginator($paginator);
        }
    }

    /**
     * Converts a collection of models to entities using the adapter.
     *
     * @param mixed $collection The collection of models.
     * @return array The array of entities.
     * @throws AdapterException If an exception occurs while converting the models to entities.
     */
    protected function convertToEntities($collection) {
        if($this->skipConversion) return $collection;
        if(is_null($collection)) return [];
        try {
            $arrayData =  is_array($collection) ? $collection : $collection->all(); 
            return array_map(function ($model) {
                    return $this->adapter()->toEntity($model);
            }, $arrayData);
        } catch (\Throwable $th) {
            throw new AdapterException("Failed on converting: ".$th->getMessage(), $th->getCode(), $th);
        }
    }

    /**
     * Converts a LengthPaginator instance to a PaginatingAggregate instance.
     *
     * @param mixed $paginator The LengthPaginator instance.
     * @return PaginatingAggregate The converted PaginatingAggregate instance.
     * @throws AdapterException If an exception occurs while converting the models to entities.
     */
    public function convertToEntityPaginator($paginator) 
    {
        $entities = $this->convertToEntities($paginator->items());
        return new PaginatingAggregate(
            $entities,
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
        );
    }

    /**
     * Set skip conversion
     * @param bool $value
     * @return self
     */
    public function setSkipConversion($value = false) {
        $this->skipConversion = $value;
        return $this;
    }
}
