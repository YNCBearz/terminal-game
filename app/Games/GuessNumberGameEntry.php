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
        if ($this->isRequestForHelp()) {
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

        if ($this->isRequestForReverseGame()) {
            return new ReverseGuessNumberGame($options);
        }

        return new GuessNumberGame($options);
    }

    public function isRequestForHelp(): bool
    {
        $options = $this->options;
        return isset($options['help']) || isset($options['h']);
    }

    private function isRequestForReverseGame(): bool
    {
        $options = $this->options;
        return isset($options['reverse']) || isset($options['r']);
    }

}