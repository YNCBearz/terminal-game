<?php

namespace App\Elements;

class GuessRecord
{
    public string $guessNumber;
    public string $guessResult;

    public function __construct(string $guessNumber, string $guessResult)
    {
        $this->guessNumber = $guessNumber;
        $this->guessResult = $guessResult;
    }
}