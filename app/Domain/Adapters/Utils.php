<?php
namespace App\Domain\Adapters;
use App\Domain\Exceptions\AdapterException;

class Utils{
   public static function convertToEntities($models, EntityAdapterInterface $adapter){
        if(is_null($models)) return [];
        try {
            $arrayData =  is_array($models) ? $models : $models->all(); 
            return array_map(function ($model) use($adapter) {
                    return $adapter->toEntity($model);
            }, $arrayData);
        } catch (\Throwable $th) {
            throw new AdapterException("Can't convert to entities", $th->getCode(), $th);
        }
   } 
}