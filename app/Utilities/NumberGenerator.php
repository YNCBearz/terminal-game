<?php

namespace App\Utilities;

class NumberGenerator
{

    public function generate4DigitWithoutRepetitions(): int
    {
        return rand(1000, 9999);
    }
}