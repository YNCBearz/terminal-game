<?php

namespace App\Games;

use App\Elements\WordWithColor;
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
    }

    private function displayForHelp(): void
    {
        Brush::paintOnConsole("Description:", ForegroundColors::YELLOW);
        Brush::paintOnConsole("  Display help for a command");
        echo PHP_EOL;
        Brush::paintOnConsole("Options", ForegroundColors::YELLOW);
        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor('  --help', ForegroundColors::GREEN),
                new WordWithColor('     Display help for the given command.'),
            ]
        );
    }
}
