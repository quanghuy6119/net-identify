<?php

namespace App\Utilities\Helpers;

use App\Domain\Exceptions\InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;

class PropertiesHelper
{
    /**
     * Get object properties of object
     *
     * @param Object $object
     * @return array
     */
    public static function getObjectVars($object): array
    {
        if (!is_object($object)) throw new InvalidArgumentException("object", "argument must be object");
    
        $objectVars = array();
        $className = get_class($object);
        $reflection = new ReflectionClass($className);

        foreach($reflection->getMethods() as $method) {

            if (!self::isGetterMethod($method)) continue;

            $nameProperty = lcfirst(substr($method->name, 3));

            $objectVars[$nameProperty] = $object->{$method->name}();
        }

        return $objectVars;
    }

    /**
     * Is getter method
     *
     * @param ReflectionMethod $method
     * @return bool
     */
    public static function isGetterMethod(ReflectionMethod $method): bool
    {
        return strpos($method->getName(), 'get') === 0 && $method->getNumberOfParameters() === 0;
    }
}
