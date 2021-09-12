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
    public function isValidGuessNumber(string $guessNumber): bool
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
        $length = $this->length;

        $guessResult = strtoupper($guessResult);
        $strSplit = str_split($guessResult);

        if (count($strSplit) != 4) {
            return false;
        }

        if ($strSplit[1] != 'A' || $strSplit[3] != 'B') {
            return false;
        }

        $bullCounts = $strSplit[0];
        $cowCounts = $strSplit[2];

        if (!is_numeric($bullCounts) || !is_numeric($cowCounts)) {
            return false;
        }

        if ($bullCounts + $cowCounts > $length) {
            return false;
        }

        return true;
    }
}