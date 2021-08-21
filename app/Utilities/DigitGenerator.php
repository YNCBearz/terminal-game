<?php

namespace App\Utilities;

class DigitGenerator
{

    public function generate4DigitWithoutRepetitions(): int
    {
        $possibleNumbers = range(0, 9);
        shuffle($possibleNumbers);

        $result = "";
        for ($i = 0; $i < 4; $i++) {
            $result .= $possibleNumbers[$i];
        }

        return $result;
    }
}