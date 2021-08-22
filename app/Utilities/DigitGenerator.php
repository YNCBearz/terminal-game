<?php

namespace App\Utilities;

class DigitGenerator
{
    public function generate4DigitWithoutRepetitions(): int
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