<?php

namespace App\Helpers;

use App\Utilities\NumberConverter;

class GuessNumberChecker
{
    /**
     * @var string $secretNumber
     */
    protected string $secretNumber;

    /**
     * @var string $guessNumber
     */
    protected string $guessNumber;

    public function __construct(string $secretNumber, string $guessNumber)
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

        $notBullSecretDigits = [];
        $notBullGuessDigits = [];
        for ($i = 0; $i < count($secretDigits); $i++) {
            if ($secretDigits[$i] == $guessDigits[$i]) {
                continue;
            }

            $notBullSecretDigits[] = $secretDigits[$i];
            $notBullGuessDigits[] = $guessDigits[$i];
        }

        $intersect = array_intersect($notBullSecretDigits, $notBullGuessDigits);

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