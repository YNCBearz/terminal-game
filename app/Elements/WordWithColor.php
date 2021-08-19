<?php

namespace App\Elements;

use App\Enums\Colors\BackgroundColors;
use App\Enums\Colors\ForegroundColors;

class WordWithColor
{
    public string $word;
    public string $foregroundColor;
    public string $backgroundColor;

    /**
     * @param string $word
     * @param string $foregroundColor
     * @param string $backgroundColor
     *
     * @see ForegroundColors
     * @see BackgroundColors
     */
    public function __construct(string $word, string $foregroundColor = '', string $backgroundColor = '')
    {
        $this->word = $word;
        $this->foregroundColor = $foregroundColor;
        $this->backgroundColor = $backgroundColor;
    }
}