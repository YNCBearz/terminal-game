<?php

namespace App\Games\Traits;

trait GameLengthTrait
{
    /**
     * @param array $options
     * @return int
     */
    private function resolveLength(array $options): int
    {
        $default = 4;

        if (isset($options['l']) && $this->isValidLength($options['l'])) {
            return (int)$options['l'];
        }

        if (isset($options['length']) && $this->isValidLength($options['length'])) {
            return (int)$options['length'];
        }

        return $default;
    }

    /**
     * @param string $length
     * @return bool
     */
    private function isValidLength(string $length): bool
    {
        if (!is_numeric($length) || $length < 1 || $length > 9) {
            return false;
        }

        return true;
    }
}