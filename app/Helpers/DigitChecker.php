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
    private function bullCounts(): int
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
    private function cowCounts(): int
    {
        $secretNumber = $this->secretNumber;
        $guessNumber = $this->guessNumber;

        $secretDigits = NumberConverter::toDigits($secretNumber);
        $guessDigits = NumberConverter::toDigits($guessNumber);

        $differentSecretDigits = [];
        $differentGuessDigits = [];
        for ($i = 0; $i < count($secretDigits); $i++) {
            if ($secretDigits[$i] == $guessDigits[$i]) {
                continue;
            }

            $differentSecretDigits[] = $secretDigits[$i];
            $differentGuessDigits[] = $guessDigits[$i];
        }

        $intersect = array_intersect($differentSecretDigits, $differentGuessDigits);

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