<?php
namespace App\Utilities\Serializer;

use App\Utilities\FlexExclusionStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer as JMSSerializer;
use JMS\Serializer\Exclusion\ExclusionStrategyInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\ArrayTransformerInterface;

class ContextType{
    public const GROUP = "group";
    public const EXCEPT = "except"; 
    public const ALL = "all"; 
    public const ONLY = "only";
    public const  DEFAULT = "default";
}