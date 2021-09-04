<?php

namespace App\Helpers;

class NumberGenerator
{
    protected int $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function generateDigitNumberWithoutRepetitions(): string
    {
        $length = $this->length;

        $possibleDigits = range(0, 9);
        shuffle($possibleDigits);

        $result = "";
        for ($i = 0; $i < $length; $i++) {
            $result .= $possibleDigits[$i];
        }

        return $result;
    }
}