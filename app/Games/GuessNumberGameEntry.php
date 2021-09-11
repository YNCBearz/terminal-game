<?php

namespace App\Games;

class GuessNumberGameEntry
{
    protected array $options;
    protected GuessNumberGameHelp $guessNumberGameHelp;

    public function __construct(array $options)
    {
        $this->options = $options;
        $this->guessNumberGameHelp = new GuessNumberGameHelp($options);
    }

    public function init()
    {
        if ($this->guessNumberGameHelp->isDisplayForHelp()) {
            $this->guessNumberGameHelp->display();
            return;
        }

        $options = $this->options;
        $game = new GuessNumberGame($options);
        $game->start();
    }
}