<?php

namespace App\Utilities;

use App\Enums\Colors\BackgroundColors;
use App\Enums\Colors\ForegroundColors;

class Brush
{
    /**
     * @param string $string
     * @param string $foregroundColor
     * @param string $backgroundColor
     * @return string
     *
     * @see ForegroundColors
     * @see BackgroundColors
     */
    public static function paint(string $string, string $foregroundColor = '', string $backgroundColor = ''): string
    {
        $colored = '';

        if (!empty($foregroundColor)) {
            $colored = "\033[".$foregroundColor."m";
        }

        if (!empty($backgroundColor)) {
            $colored .= "\033[".$backgroundColor."m";
        }

        $colored .= $string."\033[0m\n";

        return $colored;
    }
}
