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

    public function generateAllPossibleDigitNumber(): array
    {
        $length = $this->length;

        $rangeOfNumbers = range(0, pow(10, $length) - 1);

        $result = [];

        foreach ($rangeOfNumbers as $number) {
            $number = (string) $number;
            if (count(array_unique(str_split($number))) == $length) {
                $result[] = $number;
            }
        }

        return $result;
    }
}