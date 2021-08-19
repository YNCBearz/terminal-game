<?php

namespace Tests\Unit;

use App\Games\GuessNumberGame;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertStringStartsWith;

class GuessGameTest extends TestCase
{
    /**
     * @var GuessNumberGame $game
     */
    protected GuessNumberGame $game;

    /**
     * @test
     */
    public function GivenOptionsWithHelp_WhenInit_ThenEchoDescription()
    {
        $options = [
            'help' => false,
        ];

        $expected = 'Description:';
        $this->game = new GuessNumberGame($options);

        $this->game->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }
}