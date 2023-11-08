<?php
namespace App\Utilities\Helpers;

class ParamHelper{

    /**
     * Check if input is an integer type
     *
     * @param mixed $input
     * @return bool
     */
    public static function isInteger($input) : bool
    {
        return filter_var($input, FILTER_VALIDATE_INT);
    }

    /**
     * Check if input is an email
     *
     * @param mixed $input
     * @return bool
     */
    public static function isEmail($input): bool
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }
}