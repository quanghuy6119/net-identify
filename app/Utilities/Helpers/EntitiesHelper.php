<?php

namespace App\Utilities\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class EntitiesHelper
{
    /**
     * Set attributes to items
     *
     * @param array $entities
     * @param array $attributes An associative array where the keys represent added attribute names and the values are the corresponding values.
     * @return array array of entities
    */
    public static function setAttributesToEntities(array $entities, array $attributes)
    {
        $rs = [];
        foreach ($entities as $entity) {
          $entity->setAttributes($attributes);
          $rs[] = $entity;
        }
        return $rs;
    }

    /**
     * Convert data to array entities.
     *
     * @param array|Collection  $entities
     * @param [type] $adapter
     * @return array new array entities.
     */
    public static function convertToEntities($data, $adapter)
    {
        if (!($data instanceof Collection) && !$data)  return [];
        if ($data instanceof Collection && $data->isEmpty())  return [];

        if ($data instanceof Collection) $data = $data->all();
        return array_map(function($item) use($adapter) {
            $entity = $adapter->toEntity($item);
            if (!$entity) return;
            return $entity;
        }, $data);
    }

    /**
     * Hash array entities with key specified.
     *
     * @param array  $entities
     * @param string $attributes
     * @return array new array hashed.
     */
    public static function hashMap(array $entities, string $attributes)
    {
        if (!$entities) return [];
        $nameGetters = self::convertToArrayNameGetter($attributes);
        $hashMap = [];
        foreach($entities as $entity) {
            $hashMap[self::getValue($nameGetters, $entity)] = $entity;
        }
        return $hashMap;
    }

    /**
     * Filter and hash array entities with key specified.
     *
     * @param array  $entities
     * @param array  $valuesCompare
     * @param string $attributes
     * @param string $attributeCompare
     * @return array new array containing all value of attribute specified each entity in array entities with condition and hashed.
     */
    public static function filterAndHashMap(array $entities, string $attributes, array $valuesCompare, string $attributeCompare)
    {
        if (empty($entities)) return [];
        $nameGetters = self::convertToArrayNameGetter($attributes);
        $compareNameGetters = self::convertToArrayNameGetter($attributeCompare);

        $hashMap = [];
        foreach($entities as $entity) {
            // Compare value is valid
            $compareValue = self::getValue($compareNameGetters, $entity);
            if(!in_array($compareValue, $valuesCompare)) continue;

            // Hash value
            $hashMap[self::getValue($nameGetters, $entity)] = $entity;
        }
        return $hashMap;
    }

    /**
     * Unique entities.
     *
     * @param array  $entities
     * @return array new array unique entity.
     */
    public static function unique(array $entities)
    {
        return array_reduce($entities, function($rs, $entity) {
            if (!in_array($entity, $rs)) return [...$rs, $entity];
            return $rs;
        }, []);
    }

    /**
     * Pluck specified attribute of each entity in array entities.
     *
     * @param array  $entities
     * @param string $attributes
     * @return array new array containing all value of attribute specified each entity in array entities.
     */
    public static function pluck(array $entities, string $attributes)
    {
        $nameGetters = self::convertToArrayNameGetter($attributes);
        return array_map(fn ($entity) => self::getValue($nameGetters, $entity), $entities);
    }

    /**
     * Pluck specified attribute of each entity in array entities with condition.
     *
     * @param array  $entities
     * @param array  $valuesCompare
     * @param string $attributes
     * @param string $attributeCompare
     * @return array new array containing all value of attribute specified each entity in array entities with condition.
     */
    public static function pluckWithCondition(array $entities, string $attributes, array $valuesCompare, string $attributeCompare)
    {
        $nameGetters = self::convertToArrayNameGetter($attributes);
        $compareNameGetters = self::convertToArrayNameGetter($attributeCompare);
        return array_reduce($entities, function ($rs, $entity) use ($nameGetters, $compareNameGetters, $valuesCompare) {
            $compareValue = self::getValue($compareNameGetters, $entity);
            if(!in_array($compareValue, $valuesCompare)) return $rs;
            $value = self::getValue($nameGetters, $entity);
            return [...$rs, $value];
        }, []);
    }

    /**
     * Pluck specified attribute except null val of each entity in array entities.
     *
     * @param array  $entities
     * @param string $attributes
     * @return array new array containing all value of attribute specified except null val each entity in array entities.
     */
    public static function pluckExceptNull(array $entities, string $attributes)
    {
        $nameGetters = self::convertToArrayNameGetter($attributes);
        $rs = [];
        foreach($entities as $entity) {
            if (self::getValue($nameGetters, $entity) !== null)
            $rs[] = self::getValue($nameGetters, $entity);
        }
        return $rs;
    }

    /**
     * Filter array entities with array values compare
     *
     * @param array  $entities
     * @param array  $valuesCompare
     * @param string $attributes
     * @return array an array containing all the entity from entities that match with condition in array values compare.
     */
    public static function filterWithIncludeIn(array $entities, array $valuesCompare, string $attributes)
    {
        if (!$entities) return [];
        $nameGetters = self::convertToArrayNameGetter($attributes);
        return array_filter($entities, function ($entity) use ($valuesCompare, $nameGetters) {
            $valueAttribute =  self::getValue($nameGetters, $entity);
            return in_array($valueAttribute, $valuesCompare);
        });
    }

    /**
     * Computes the array entities with each entity has attribute difference with array values compare
     *
     * @param array  $entities
     * @param array  $valuesCompare
     * @param string $attributes
     * @return array an array containing all the entity from entities that are not present attribute in array values compare.
     */
    public static function diff(array $entities, array $valuesCompare, string $attributes)
    {
        $nameGetters = self::convertToArrayNameGetter($attributes);
        $array = Arr::where($entities, function ($entity) use ($valuesCompare, $nameGetters) {
            $valueAttribute =  self::getValue($nameGetters, $entity);
            return !in_array($valueAttribute, $valuesCompare);
        });
        return $array;
    }

    /**
     * Return the first element in an array entities passing a given truth test.
     *
     * @param array  $entities
     * @param [type]  $valuesCompare
     * @param string $attributes
     */
    public static function equalFirst(array $entities, $valueCompare, string $attributes)
    {
        $nameGetters = self::convertToArrayNameGetter($attributes);
        $entity = Arr::first($entities, function ($entity) use ($valueCompare, $nameGetters) {
            $valueAttribute =  self::getValue($nameGetters, $entity);
            $expression = self::makeBasicExpression("==", "&&", $valueAttribute, $valueCompare);
            return self::executeExpression($expression);
        });
        return $entity;
    }

    /**
     * Return the first element in an array entities passing with many given truth test.
     *
     * @param array  $entities
     * @param array  ...$arrayConditions [value compare, attributes]
     */
    public static function equalFirstManyCondition(array $entities, array ...$arrayConditions)
    {
        $entity = Arr::first($entities, function ($entity) use ($arrayConditions) {
            $expression = "";
            foreach ($arrayConditions as $condition) {
                $nameGetters = self::convertToArrayNameGetter($condition[1]);
                $valueAttribute =  self::getValue($nameGetters, $entity);
                $expr = self::makeBasicExpression("==", "&&", $valueAttribute, $condition[0]);
                $expression = self::makeLogicOperator("&&", $expression, $expr);
            }
            return self::executeExpression($expression);
        });
        return $entity;
    }

    /**
     * Make logic operator
     *
     * @param string    $logicOperator
     * @param string ...$expressions
     * @return string
     */
    private static function makeLogicOperator(
        string $logicOperator,
        string ...$expressions
    ) {
        $rs = "";
        foreach ($expressions as $index => $expr) {
            $index == 0 || $expr == "" || $rs == "" ? $logicOpt = ""
                : $logicOpt = $logicOperator;
            $rs = $rs . $logicOpt . $expr;
        }
        return $rs;
    }

    /**
     * Make compare expression operator
     *
     * @param [type] $firstValue
     * @param [type] $secondValue
     * @param string $cmpOperator
     * @return string
     */
    private static function makeCmpOperator($firstValue, $secondValue, $cmpOperator)
    {
        $expression = "";
        if ($firstValue instanceof Carbon || $secondValue instanceof Carbon) {
            $expression = self::makeCmpCarbon($firstValue, $secondValue, $cmpOperator);
        } else {
            $expression = $firstValue . $cmpOperator . $secondValue;
        }
        return $expression;
    }

    /**
     * Change value null to string "null"
     *
     * @param [type] $value
     * @return string
     */
    private static function changeNullToString($value)
    {
        if ($value == null) $value = "null";
        return $value;
    }

    /**
     * Make compare expression of carbon function
     *
     * @param [type] $firstValue
     * @param [type] $secondValue
     * @param string $cmpOperator
     * @return string
     */
    private static function makeCmpCarbon($firstValue, $secondValue, $cmpOperator)
    {
        switch ($cmpOperator) {
            case "==":
                return "Carbon::parse('$firstValue')->eq('$secondValue')";
                break;
            case "!=":
                return "Carbon::parse('$firstValue')->ne('$secondValue')";
                break;
            case ">":
                return "Carbon::parse('$firstValue')->gt('$secondValue')";
                break;
            case ">=":
                return "Carbon::parse('$firstValue')->gte('$secondValue')";
                break;
            case "<":
                return "Carbon::parse('$firstValue')->lt('$secondValue')";
                break;
            case "<=":
                return "Carbon::parse('$firstValue')->lte('$secondValue')";
                break;
            default:
                break;
        }
    }

    /**
     * Make basic expression
     *
     * @param string $cmpOperator
     * @param string $logicOperator
     * @param [type] $firstValue
     * @param [type] $valueData
     * @return string
     */
    private static function makeBasicExpression(
        string $cmpOperator,
        string $logicOperator,
        $firstValue,
        $valueData
    ) {
        $firstValue = self::changeNullToString($firstValue);
        $expression = "";
        $numberOfValues = 1;
        if (is_array($valueData)) {
            $numberOfValues = count($valueData);
        } else {
            $valueData = array($valueData);
        };
        for ($i = 0; $i < $numberOfValues; $i++) {
            $secondValue = self::changeNullToString($valueData[$i]);
            $expr = self::makeCmpOperator($firstValue, $secondValue, $cmpOperator);
            $expression = self::makeLogicOperator($logicOperator, $expression, $expr);
        }
        return $expression;
    }

    /**
     * Execute expression
     *
     * @param string $expression
     */
    private static function executeExpression($expression)
    {
        $expression = "use Carbon\Carbon; return " . $expression . ";";
        return eval($expression);
    }

    /**
     * Get value with getter function of entity
     *
     * @param array  $nameGetters
     * @param        $entity
     */
    private static function getValue(array $nameGetters, $entity)
    {
        foreach ($nameGetters as $getter) {
            $entity = $entity->{$getter}();
        }
        return $entity;
    }

    /**
     * Convert string name attributes to array name getter function
     *
     * @param string  $attributes
     * @return array
     */
    private static function convertToArrayNameGetter($attributes)
    {
        $attributes = explode('.', $attributes);
        $nameGetters = array();
        foreach ($attributes as $attribute) {
            $nameGetters[] = 'get' . ucwords($attribute);
        }
        return $nameGetters;
    }
}
