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

    /**
     * @return int
     */
    public function cowCounts(): int
    {
        $secretNumber = $this->secretNumber;
        $guessNumber = $this->guessNumber;

        $secretDigits = NumberConverter::toDigits($secretNumber);
        $guessDigits = NumberConverter::toDigits($guessNumber);

        for ($i = 0; $i < count($secretDigits); $i++) {
            if ($secretDigits[$i] == $guessDigits[$i]) {
                unset($secretDigits[$i]);
                unset($guessDigits[$i]);
            }
        }

        $intersect = array_intersect($secretDigits, $guessDigits);

        return count($intersect);
    }

    /**
     * @return string (ex. 0A2B)
     */
    public function getResult(): string
    {
        $bullCounts = $this->bullCounts();
        $cowCounts = $this->cowCounts();

        return $bullCounts.'A'.$cowCounts.'B';
    }

}