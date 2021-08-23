<?php

namespace App\Utilities;

class NumberConverter
{
    /**
     * @param string $number
     * @return array
     */
    public static function toDigits(string $number): array
    {
        return str_split($number);
    }
}