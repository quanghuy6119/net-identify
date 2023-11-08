<?php

namespace App\Utilities\Helpers;

use App\Domain\Entities\Entity;
use App\Domain\Exceptions\ArgumentNullException;
use App\Domain\Exceptions\InvalidArgumentException;

class EntityArrayHelper
{
    /**
     * Pluck attribute from array of $entities
     * @return array
     */
    public static function pluck(array $entities, string $attributeName){
        if(is_null($entities)) throw new ArgumentNullException("entities", "The entities argument is a null value");
        if(count($entities) === 0) return [];
        if(is_null($attributeName) || strlen($attributeName) === 0) throw new InvalidArgumentException("attributeName", "The attributeName argument is a null value or empty");
        
        return array_map(function (Entity $entity) use($attributeName){
            return $entity->getAttribute($attributeName);
        }, $entities);
    }
}