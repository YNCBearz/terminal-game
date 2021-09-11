<?php

namespace App\Games;

use App\Elements\WordWithColor;
use App\Enums\Colors\ForegroundColors;
use App\Utilities\Brush;

class GuessNumberGameHelp
{
    protected array $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function display(): void
    {
        Brush::paintOnConsole("Description:", ForegroundColors::BROWN);
        Brush::paintOnConsole("  Display help for a command");
        echo PHP_EOL;
        Brush::paintOnConsole("Options", ForegroundColors::BROWN);
        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor("  -h, --help", ForegroundColors::GREEN),
                new WordWithColor("         Display help for the given command. \n"),
                new WordWithColor("  -l, --length", ForegroundColors::GREEN),
                new WordWithColor("       Setting for the digit number (default: 4)."),
            ],
        );
    }

    public function isDisplayForHelp(): bool
    {
        $options = $this->options;
        return isset($options['help']) || isset($options['h']);
    }
}