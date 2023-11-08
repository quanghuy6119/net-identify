<?php

namespace App\Utilities\Helpers;

use Ramsey\Uuid\Uuid;

class StringHelper
{
    /**
     * Convert an camel case string to snake case string
     *
     * @param string $camelString
     * @return string
     */
    public static function convertCamelToSnakeCase(string $camelString) : string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $camelString));
    }

    /**
     * Convert an camel case string to snake case string with number
     *
     * @param string $camelString
     * @return string
     */
    public static function convertCamelToSnakeCaseWithNumber(string $camelString): string
    {
        return strtolower(preg_replace('/([a-zA-Z])(\d+)/', '$1_$2', lcfirst($camelString)));
    }

    /**
     * Convert an camel case string to sentence
     *
     * @param string $snakeString
     * @return string
     */
    public static function convertCamelCaseToSentence(string $camelCaseString) : string
    {
        $result = preg_replace('/(?<!^)([A-Z])/', ' $0', $camelCaseString);
        return ucfirst(strtolower($result));
    }

    /**
     * Convert an snake case string to sentence
     *
     * @param string $snakeString
     * @return string
     */
    public static function convertSnakeCaseToSentence(string $snakeString) : string
    {
        // Break words by underline
        $words = explode('_', $snakeString);
        $cmWords = [];
        foreach ($words as $index => $word) {
            if ($index == 0) {
                $cmWords[] = $word;
                continue;
            }
            $cmWords[] = $word;
        }
        if (count($cmWords) > 1) return ucfirst(implode(' ', $cmWords));
        // Break words by hyphen
        $words = explode('-', $snakeString);
        $cmWords = [];
        foreach ($words as $index => $word) {
            if ($index == 0) {
                $cmWords[] = $word;
                continue;
            }
            $cmWords[] = $word;
        }
        return ucfirst(implode(' ', $cmWords));
    }

    /**
     * Create random code with 16 characters.
     *
     * @return string
     */
    public static function createRandomCode(): string
    {
        // Random 16 bytes
        $bytes = random_bytes(16);
        // convert to hex
        return bin2hex($bytes);
    }

    /**
     * Generate format code
     *
     * @param string $latestCode
     * @param int    $numberFormat
     * @param int    $numberSymbol
     * @return string
     */
    public static function generateFormatCode(string $latestCode, int $numberFormat, int $numberSymbol = 0): string
    {
        // Trim space
        $latestCode = trim($latestCode);
        // Get prefix symbol
        $prefixSymbol = substr($latestCode, 0, $numberSymbol);
        // Make format number
        $format = '%0' . $numberFormat . 'd';
        // Get new number
        $number = substr($latestCode, $numberSymbol) + 1;
        // Make new number format
        $number = sprintf($format, $number);
        // Return code
        return $prefixSymbol . $number;
    }

    /**
     * Generate uuid
     *
     * @return string
     */
    public static function generateUuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
