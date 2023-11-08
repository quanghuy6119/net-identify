<?php
namespace App\Utilities\Helpers;
use Carbon\Carbon;

class DateTimeHelper{
    
    public static function convertToIso(?Carbon $date){
        if(is_null($date)) return null;
        return $date->toIso8601String();
    }
    
    public static function parseFromString($date){
        if(is_null($date)) return null;
        return Carbon::parse($date);
    } 
}