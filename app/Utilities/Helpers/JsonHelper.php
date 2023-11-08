<?php

namespace App\Utilities\Helpers;

use InvalidArgumentException;

class JsonHelper
{
    /**
     * Decode a JSON if input is JSON
     *
     * @param mixed $json
     * @return array
     */
    public static function decode($json) : array
    {
        if (!$json) return [];
        if (is_array($json)) return $json;
        if (is_string($json)) {
            $array = json_decode($json, true);
            if (is_array($array)) return $array;
        }
        throw new InvalidArgumentException("Invalid JSON or array.");
    }

    /**
     * Decode a body response of http client
     *
     * @param \Psr\Http\Message\ResponseInterface $res
     * @return array|null
     */
    public static function parseBody($res) : ?array
    {
        return json_decode($res->getBody(), true);
    }
}
