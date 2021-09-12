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
        /*
         * We have to add some digit number start with "0"
         */
        $startWithZeroNumbers = $this->generatePossibleDigitNumberStartWithZero();
        $rangeOfNumbers = $this->generatePossibleDigitNumberOfRange();

        return array_merge($startWithZeroNumbers, $rangeOfNumbers);
    }

    /**
     * @param string $number
     * @param int $length
     * @return bool
     */
    private function isValidNumberOfLength(string $number, int $length): bool
    {
        return count(array_unique(str_split($number))) == $length;
    }

    /**
     * @return array
     */
    private function generatePossibleDigitNumberStartWithZero(): array
    {
        $length = $this->length;

        if ($length == 1) {
            return [];
        }

        $rangeOfNumbers = range(0, pow(10, $length - 1) - 1);

        $result = [];
        foreach ($rangeOfNumbers as $number) {
            $number = (string)$number;
            $number = "0$number";
            if ($this->isValidNumberOfLength($number, $length)) {
                $result[] = $number;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    private function generatePossibleDigitNumberOfRange(): array
    {
        $length = $this->length;

        $rangeOfNumbers = range(0, pow(10, $length) - 1);

        $result = [];

        foreach ($rangeOfNumbers as $number) {
            $number = (string)$number;
            if ($this->isValidNumberOfLength($number, $length)) {
                $result[] = $number;
            }
        }

        return $result;
    }
}