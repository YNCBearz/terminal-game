<?php

namespace Tests\Unit\Games;

use App\Games\GuessNumberGame;
use PHPUnit\Framework\TestCase;

class GuessGameTest extends TestCase
{
    /**
     * @var GuessNumberGame $sut
     */
    protected GuessNumberGame $sut;

    /**
     * @param array $options
     *
     * @dataProvider optionsWithHelp
     * @test
     */
    public function GivenOptionsWithHelp_WhenInit_ThenEchoHelp(array $options)
    {
        $expected = 'Display help for a command';
        $this->sut = new GuessNumberGame($options);

        $this->sut->init();
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
        $expected = 'Guess Number (4-digit)';
        $this->sut = new GuessNumberGame([]);

        $this->sut->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }
}