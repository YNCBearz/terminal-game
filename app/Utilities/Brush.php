<?php

namespace App\Utilities;

use App\Elements\WordWithColor;
use App\Enums\Colors\BackgroundColors;
use App\Enums\Colors\ForegroundColors;

class Brush
{
    /**
     * @param string $word
     * @param string $foregroundColor
     * @param string $backgroundColor
     * @return string
     *
     * @see ForegroundColors
     * @see BackgroundColors
     */
    public static function paint(string $word, string $foregroundColor = '', string $backgroundColor = ''): string
    {
        $colored = '';

        if (!empty($foregroundColor)) {
            $colored = "\033[".$foregroundColor."m";
        }

        if (!empty($backgroundColor)) {
            $colored .= "\033[".$backgroundColor."m";
        }

        $colored .= $word."\033[0m";

        return $colored;
    }

    /**
     * @param string $word
     * @param string $foregroundColor
     * @param string $backgroundColor
     *
     * @see ForegroundColors
     * @see BackgroundColors
     */
    public static function paintOnConsole(string $word, string $foregroundColor = '', string $backgroundColor = '')
    {
        echo self::paint($word, $foregroundColor, $backgroundColor) . "\n";
    }

    /**
     * @param WordWithColor[] $wordWithColors
     */
    public static function paintMultiWordsOnConsole(array $wordWithColors)
    {
        $result = '';

        foreach ($wordWithColors as $wordWithColor) {
            $result .= self::paint($wordWithColor->word, $wordWithColor->foregroundColor, $wordWithColor->backgroundColor);
        }

        self::paintOnConsole($result);
    }
}
