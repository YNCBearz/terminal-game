<?php

namespace App\Utilities;

class NumberConverter
{
    public function convertToDigits(int $number): array
    {
        $result = [];

        while ($number % 10 > 0) {
            $result[] = ($number % 10);
            $number = $number / 10;
        }

        return array_reverse($result);
    }
}