<?php
namespace App\Utilities\Helpers;

class ArrayHelper{
    /**
     * Check whether keys are existed on a array or not 
     * @param array $keys
     * @param array $array 
     * @return bool
     */
    public static function checkKeyExists(array $keys, array $array): bool {
        $diff = array_diff_key(array_flip($keys), $array);
        return count($diff) === 0;
    }

    /**
     * Check whether keys are existed on a array or not
     * @param array $arr
     * @param Callback $getKeyCallback 
     */
    public static function toKeyValues(array $arr, callable $getKeyCallback){
        if (is_null($getKeyCallback)) throw new \InvalidArgumentException("Callback must be a function");
       
        $keys = array_map(function ($item) use ($getKeyCallback) {
            return $getKeyCallback($item);
        }, $arr);
    
        return array_combine($keys, $arr);
    }

    /**
     * Flatten nested array
     *
     * @param array $array
     * @param string $prefix
     * @param string $separator
     * @return array
    */
    public static function flattenNestedArray(array $array, string $prefix = '', string $separator = "_")
    {
        $result = [];

        foreach ($array as $key => $value) {
            $newKey = ($prefix . (empty($prefix) ? '' : $separator) . $key);

            if (is_array($value)) {
                $flattenedValue = self::flattenNestedArray($value, $newKey, $separator);

                $result = array_merge($result, $flattenedValue);
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Change Key Of Array
     * 
     * @param array $array
     * @param mixed $old_key
     * @param mixed $new_key
     * @return array
     */
    public static function changeKey(array $array, $oldKey, $newKey): array
    {

        if (!array_key_exists($oldKey, $array))
            return $array;

        $keys = array_keys($array);
        $keys[array_search($oldKey, $keys)] = $newKey;

        return array_combine($keys, $array);
    }
}