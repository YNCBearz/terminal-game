<?php

namespace App\Games;

use App\Enums\Colors\ForegroundColors;
use App\Games\Contracts\Gameable;
use App\Utilities\Brush;

class ReverseGuessNumberGame implements Gameable
{
    protected array $options;
    protected int $length = 4;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function start()
    {
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

        //While
        //選一個可能的數字

        //等待User 0A0B

        //過濾可能的數字

    }
}