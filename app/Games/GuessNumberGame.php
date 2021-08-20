<?php

namespace App\Games;

use App\Elements\WordWithColor;
use App\Enums\Colors\BackgroundColors;
use App\Enums\Colors\ForegroundColors;
use App\Utilities\Brush;

class GuessNumberGame
{
    /**
     * @var array $options
     */
    protected array $options;

    /**
     * @var bool $isDisplayForHelp
     */
    protected bool $isDisplayForHelp;

    public function __construct($options)
    {
        $this->options = $options;

        $this->isDisplayForHelp = isset($options['help']) || isset($options['h']);
    }

    public function init()
    {
        if ($this->isDisplayForHelp) {
            $this->displayForHelp();
        }

        $this->pressStart();

        $this->hostGame();
    }

    private function displayForHelp(): void
    {
        Brush::paintOnConsole("Description:", ForegroundColors::BROWN);
        Brush::paintOnConsole("  Display help for a command");
        echo PHP_EOL;
        Brush::paintOnConsole("Options", ForegroundColors::BROWN);
        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor("  -h, --help", ForegroundColors::GREEN),
                new WordWithColor("     Display help for the given command."),
            ]
        );
    }

    private function pressStart()
    {
        Brush::paintOnConsole("Guess Number (4-digit)", ForegroundColors::WHITE);
        echo PHP_EOL;
        Brush::paintOnConsole("Description:", ForegroundColors::BROWN);
        Brush::paintOnConsole("  You must guess a 4-digit secret number selected by the computer");
        echo PHP_EOL;
        Brush::paintOnConsole("Please enter a 4-digit number:", ForegroundColors::GREEN);
    }

    private function hostGame()
    {
        //產生4個不重複的數字

        //檢查input是4個不重複的數字
//        $inputNumber = readline("> ");

        //判斷1A2B

        //4A => Game End

        //else => 回傳目前猜的結果



    }
}
