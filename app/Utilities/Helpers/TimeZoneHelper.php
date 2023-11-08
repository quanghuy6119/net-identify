<?php
namespace App\Utilities\Helpers;
use Carbon\Carbon;

class TimeZoneHelper{
    /**
     * Get user timezone
     */
    static public function getUserTimezone() {
        return optional(auth()->user())->timezone ?? config('app.timezone');
    }

    /**
     * Convert to user's timezone
     */
    static public function convertToLocal(?Carbon $date): ?Carbon {
        if(is_null($date)) return $date;
        $timezone = TimeZoneHelper::getUserTimezone();
        return $date->setTimezone(($timezone));
    }

    /**
     * Convert form local timezone to UTC
     * @param $date
     * @return Carbon\Carbon
     */
    static public function convertFromLocal($date) : Carbon
    {
        return Carbon::parse($date, auth()->user()->timezone)->setTimezone('UTC');
    }
}