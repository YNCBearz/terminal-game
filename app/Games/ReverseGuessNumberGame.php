<?php

namespace App\Games;

use App\Enums\Colors\ForegroundColors;
use App\Games\Contracts\Gameable;
use App\Games\Traits\GameLengthTrait;
use App\Helpers\InputChecker;
use App\Helpers\NumberGenerator;
use App\Utilities\Brush;

class ReverseGuessNumberGame implements Gameable
{
    use GameLengthTrait;

    protected array $options;
    protected int $length;
    protected NumberGenerator $numberGenerator;
    protected array $possibleNumbers;
    protected int $guessTimes = 1;

    public function __construct(array $options)
    {
        $this->options = $options;

        $this->length = $this->resolveLength($options);

        $this->numberGenerator = new NumberGenerator($this->length);
        $this->inputChecker = new InputChecker($this->length);
    }

    public function start()
    {
        $length = $this->length;
        if ($length > 4) {
            Brush::paintOnConsole(
                "Sorry, Reverse Guess Number above 4-digit is not supported right now.",
                ForegroundColors::LIGHT_PURPLE
            );

            return;
        }

        $this->displayGameInfo();
        $this->hostGame();
    }

    private function displayGameInfo()
    {
        $length = $this->length;

        Brush::paintOnConsole("Reverse Guess Number ($length-digit)", ForegroundColors::WHITE);
        echo PHP_EOL;
        Brush::paintOnConsole("Description:", ForegroundColors::BROWN);
        Brush::paintOnConsole("  Set a $length-digit secret number, and computer will guess the secret number");
        echo PHP_EOL;
    }

    private function hostGame()
    {
        $this->possibleNumbers = $this->numberGenerator->generateAllPossibleDigitNumber();

        $guessResult = '0A0B';

        while (!$this->isGameSet($guessResult)) {
            $guessNumber = (string)$this->possibleNumbers[0];

            $this->displayGuessNumber($guessNumber);
            $this->askForGuessResult();

            $guessResult = readline("> ");
            $guessResult = strtoupper($guessResult);

            if ($guessResult == 'EXIT') {
                return;
            }

            if (!$this->inputChecker->isValidGuessResult($guessResult)) {
                $this->displayErrorInputMessage();
                continue;
            }

            if ($this->isGameSet($guessResult)) {
                echo PHP_EOL;
                $this->displayGameSetInfo();

                return;
            }

            $this->guessTimes++;
            $this->filterPossibleNumbersWithGameResult($guessNumber, $guessResult);
        }
    }

    /**
     * @param string $guessResult
     * @return bool
     */
    private function isGameSet(string $guessResult): bool
    {
        $length = $this->length;

        return $guessResult == $length.'A0B';
    }

    /**
     * @param string $guessNumber
     */
    private function displayGuessNumber(string $guessNumber)
    {
        Brush::paintOnConsole(
            "ʕ •ᴥ•ʔ： $guessNumber?",
            ForegroundColors::BROWN
        );
    }

    private function displayErrorInputMessage()
    {
        $length = $this->length;
        Brush::paintOnConsole(
            "There are something wrong with the guess result you input, please try again.",
            ForegroundColors::RED
        );
    }

    private function askForGuessResult()
    {
        Brush::paintOnConsole("Please enter a guess result: (such as 0A1B)", ForegroundColors::GREEN);
    }

    private function displayGameSetInfo()
    {
        $guessTimes = $this->guessTimes;

        Brush::paintOnConsole("ʕ •ᴥ•ʔ：Thank you for playing. (guess times: $guessTimes)", ForegroundColors::BROWN);
    }

    /**
     * @param string $guessNumber
     * @param string $guessResult
     */
    private function filterPossibleNumbersWithGameResult(string $guessNumber, string $guessResult)
    {
        $possibleNumbers = $this->possibleNumbers;
    }
}