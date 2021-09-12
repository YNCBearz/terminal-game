<?php

namespace App\Helpers;

class ReverseGuessNumberChecker
{
    protected string $guessNumber;
    protected string $guessResult;

    public function __construct(string $guessNumber, string $guessResult)
    {
        $this->guessNumber = $guessNumber;
        $this->guessResult = $guessResult;
    }

    public function isFitNumber(string $number): bool
    {
        return true;
    }

}