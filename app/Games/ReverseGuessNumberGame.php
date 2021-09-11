<?php

namespace App\Games;

use App\Games\Contracts\Gameable;

class ReverseGuessNumberGame implements Gameable
{
    protected array $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function start()
    {
        //
    }
}