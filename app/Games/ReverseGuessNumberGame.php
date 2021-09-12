<?php

namespace App\Games;

use App\Enums\Colors\ForegroundColors;
use App\Games\Contracts\Gameable;
use App\Games\Traits\GameLengthTrait;
use App\Helpers\NumberGenerator;
use App\Utilities\Brush;

class ReverseGuessNumberGame implements Gameable
{
    use GameLengthTrait;

    protected array $options;
    protected int $length;
    protected NumberGenerator $numberGenerator;

    public function __construct(array $options)
    {
        $this->options = $options;

        $this->length = $this->resolveLength($options);

        $this->numberGenerator = new NumberGenerator($this->length);
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
        //產生所有可能的數字
        $possibleNumbers = $this->numberGenerator->generateAllPossibleDigitNumber();

        //While
        //選一個可能的數字

        //等待User 0A0B

        //過濾可能的數字

    }
}