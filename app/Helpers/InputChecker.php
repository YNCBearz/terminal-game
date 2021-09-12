<?php

namespace App\Helpers;

class InputChecker
{
    protected int $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    /**
     * @param string $guessNumber
     * @return bool
     */
    public function isValid(string $guessNumber): bool
    {
        $length = $this->length;

        return strlen($guessNumber) == $length &&
            is_numeric($guessNumber) &&
            count(array_unique(str_split($guessNumber))) == $length;
    }

    /**
     * @param string $guessResult
     * @return bool
     */
    public function isValidGuessResult(string $guessResult): bool
    {
        return false;
    }
}