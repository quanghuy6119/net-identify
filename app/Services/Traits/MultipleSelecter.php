<?php
namespace App\Services\Traits;

use App\Domain\Exceptions\ServiceException;
use App\Domain\Repositories\Criteria\IncludeInCriteria;
use Symfony\Component\HttpFoundation\Response;

trait MultipleSelecter{

    public function selectByIds(array $ids){
        // get base repository
        $baseRepository = $this->repository;
        if(!$baseRepository) throw new ServiceException("The repository is not defined");
        // resolve criteria
        $criteria = null;
        try {
            $criteria = $this->resolve(IncludeInCriteria::class, 
                                    ['attribute' => "id", 'value' => $ids]);
        }
        catch (\Exception $ex){
            throw new ServiceException("Couldn't resolve ".IncludeInCriteria::class);
        }
        $baseRepository->resetCriteria()->pushCriteria($criteria);
        $matchedRecords = $baseRepository->getAll();
        $baseRepository->resetCriteria();
        $data = $this->serializer()->with($matchedRecords)->getArray(); 
        return $this->sendSuccess("Get successfully", $data, Response::HTTP_OK);
    }
    
}