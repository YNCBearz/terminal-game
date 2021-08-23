<?php

namespace App\Utilities;

class NumberGenerator
{
    public static function generate4DigitNumberWithoutRepetitions(): string
    {
        $possibleDigits = range(0, 9);
        shuffle($possibleDigits);

        $result = "";
        for ($i = 0; $i < 4; $i++) {
            $result .= $possibleDigits[$i];
        }

        return $result;
    }
}