<?php

namespace Tests\Unit\Games;

use App\Games\GuessNumberGameEntry;
use PHPUnit\Framework\TestCase;

class GuessGameEntryTest extends TestCase
{
    /**
     * @var GuessNumberGameEntry $sut
     */
    protected GuessNumberGameEntry $sut;

    protected function setUp(): void
    {
        parent::setUp();
        ob_start();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        ob_end_clean();
    }

    /**
     * @param array $options
     *
     * @dataProvider optionsWithHelp
     * @test
     */
    public function GivenOptionsWithHelp_WhenInit_ThenEchoHelp(array $options)
    {
        $expected = 'Display help for a command';
        $this->sut = new GuessNumberGameEntry($options);

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
        $this->sut = new GuessNumberGameEntry([]);

        $this->sut->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }
}