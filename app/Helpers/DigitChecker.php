<?php

namespace App\Helpers;

use App\Utilities\NumberConverter;

class DigitChecker
{
    /**
     * @var int $secretNumber
     */
    protected int $secretNumber;

    /**
     * @var int $guessNumber
     */
    protected int $guessNumber;

    public function __construct(int $secretNumber, int $guessNumber)
    {
        $this->secretNumber = $secretNumber;
        $this->guessNumber = $guessNumber;
    }

    /**
     * @return int
     */
    public function bullCounts(): int
    {
        $secretNumber = $this->secretNumber;
        $guessNumber = $this->guessNumber;

        $secretDigits = NumberConverter::toDigits($secretNumber);
        $guessDigits = NumberConverter::toDigits($guessNumber);

        $result = 0;
        for ($i = 0; $i < count($secretDigits); $i++) {
            if ($secretDigits[$i] == $guessDigits[$i]) {
                $result++;
            }
        }

        return $result;
    }

}