<?php

namespace App\Utilities\Serializer;

use JMS\Serializer\Exclusion\ExclusionStrategyInterface;
use JMS\Serializer\Context;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\SerializerInterface;

class ExceptExclusionStrategy implements ExclusionStrategyInterface{
    
    private array $properties = [];
    
    public function __construct(array $properties = [])
    {
        $this->properties = $properties;
    }

    public function shouldSkipClass(ClassMetadata $metadata, Context $navigatorContext): bool
    {
        return false;
    }

    public function shouldSkipProperty(PropertyMetadata $property, Context $navigatorContext): bool
    {
        return $this->checkExclusion($property);
    }
    private function checkExclusion(PropertyMetadata $property){
        if (is_null($this->properties)) return false;
        foreach ($this->properties as $name){
            if($name === $property->name || $name === $property->serializedName){
                return true;
            }
        }
        return false;
    } 
}