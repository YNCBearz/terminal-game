<?php

namespace App\Games;

class GuessNumberGame
{
    /**
     * @var array $options
     */
    protected array $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    public function init()
    {
        echo "Description: 1111";
    }
}
