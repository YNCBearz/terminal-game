<?php

namespace App\Utilities;

class TypeSetting
{
    /**
     * @param int $times
     * @return string
     */
    public static function generateBlank(int $times): string
    {
        return str_repeat(' ', $times);
    }
}