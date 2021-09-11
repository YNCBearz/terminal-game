<?php

namespace App\Games;

use App\Games\Contracts\Gameable;

class GuessNumberGameEntry
{
    protected array $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function init()
    {
        if ($this->isDisplayForHelp()) {
            $guessNumberGameHelp = new GuessNumberGameHelp($this->options);
            $guessNumberGameHelp->display();
            return;
        }

        $game = $this->resolveGame();
        $game->start();
    }

    /**
     * @return Gameable
     */
    private function resolveGame(): Gameable
    {
        $options = $this->options;

        $game = new GuessNumberGame($options);
        return $game;
    }

    public function isDisplayForHelp(): bool
    {
        $options = $this->options;
        return isset($options['help']) || isset($options['h']);
    }

}