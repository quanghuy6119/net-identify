<?php
namespace App\Domain\Repositories\Traits;

use App\Domain\Exceptions\CanNotMakeQueryException;
use Illuminate\Database\QueryException;
use App\Domain\Exceptions\Exception;
use App\Domain\Exceptions\DatabaseException;
use App\Domain\Repositories\DataManager;

trait DeleteByIds{

    /**
     * Delete many record 
     *
     * @param array $ids
     * @return int
     * @throws DatabaseException
     * @throws Exception
     */
    public function deleteByIds(array $ids)
    {
        $query = null;
        if (method_exists($this, 'makeQuery')) {
            $query = $this->makeQuery();
        } else if (property_exists($this, 'manager')) {
            if ($this->manager instanceof DataManager) $query = $this->manager->makeQuery();
        }
         
        if (is_null($query)) throw new CanNotMakeQueryException(get_class($this) .' cannot make query', 500); 
        try {
            if(empty($ids)) return null;
            return $query->whereIn('id', $ids)->delete();
        } catch (QueryException $ex) {
            throw new DatabaseException("Database exception: " . $ex->getMessage());
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}