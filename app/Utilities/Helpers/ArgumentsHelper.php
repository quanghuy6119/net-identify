<?php
namespace App\Utilities\Helpers;

use App\Domain\Exceptions\InvalidArgumentException;
use Carbon\Carbon;

class ArgumentsHelper{
    /**
     * @throws InvalidArgumentException 
     */
    public static function checkOrFail($name, $value, $callback, $exceptionMessage = null)
    {
        if (!$callback($value)) {
            throw new InvalidArgumentException($name, $exceptionMessage ?? "$name is invalid");
        }
    }

    /**
     * @throws InvalidArgumentException 
     */
    public static function checkInArray(array $attributes, $name, $callback, $exceptionMessage = null)
    {
        if (!$callback($attributes[$name])) {
            throw new InvalidArgumentException($name, $exceptionMessage ?? "$name is invalid");
        }
    }

     /**
     * @throws InvalidArgumentException 
     */
    public static function parse($name, $value, $callback, $exceptionMessage = null){
        try {
            return $callback($value);
        } catch (\Throwable $th) {
           throw new InvalidArgumentException($name,  $exceptionMessage ?? "$name's value is incorrect");
        }
    }

     /**
     * @throws InvalidArgumentException 
     */
    public static function parseToDateTime($name, $value, $exceptionMessage = null){
        return self::parse($name, $value, function ($data) {
            return Carbon::parse($data);
        }, "The datetime format is incorrect");
    }
}