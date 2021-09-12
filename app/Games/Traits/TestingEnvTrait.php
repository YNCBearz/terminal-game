<?php

namespace App\Games\Traits;

trait TestingEnvTrait
{
    /**
     * @return bool
     */
    private function isTestingEnv(): bool
    {
        if (!isset($_ENV['APP_ENV'])) {
            $_ENV['APP_ENV'] = getenv('APP_ENV');
        }

        return $_ENV['APP_ENV'] == 'testing';
    }
}