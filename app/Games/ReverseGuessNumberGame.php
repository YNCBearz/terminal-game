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
            Brush::paintOnConsole("Sorry, Reverse Guess Number above 4-digit is not supported right now.", ForegroundColors::LIGHT_PURPLE);
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
            $guessNumber =$this->possibleNumbers[0];

            $this->displayGuessNumber($guessNumber);

            $guessResult = readline("> ");

            if ($guessResult == 'exit') {
                return;
            }

            if (!$this->inputChecker->isValidGuessResult($guessResult)) {
                $this->displayErrorInputMessage();
                continue;
            }
        }
        //While
        //選一個可能的數字

        //等待User 0A0B

        //過濾可能的數字

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

    }
}