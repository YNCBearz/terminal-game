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
     * @param array $options
     *
     * @dataProvider optionsWithHelp
     * @test
     */
    public function GivenOptionsWithHelp_WhenInit_ThenEchoHelp(array $options)
    {
        $expected = 'Display help for a command';
        $this->game = new GuessNumberGame($options);

        $this->game->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }

    /**
     * @return array
     */
    public function optionsWithHelp(): array
    {
        return [
            [
                [
                    'help' => false,
                ],
            ],
            [
                [
                    'h' => false,
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function GivenNoOptions_WhenInit_ThenPressStart()
    {
        $expected = 'Guess Number (4 digits)';
        $this->game = new GuessNumberGame([]);

        $this->game->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }
}