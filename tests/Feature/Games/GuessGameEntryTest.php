<?php

namespace Tests\Feature\Games;

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
     * @test
     *
     * @param array $options
     *
     * @dataProvider optionsWithHelp
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
    public function GivenNoOptions_WhenInit_ThenStartGuessGame()
    {
        $expected = 'Guess Number (4-digit)';
        $this->sut = new GuessNumberGameEntry([]);

        $this->sut->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }

    /**
     * @test
     *
     * @param array $options
     *
     * @dataProvider optionsWithReverse
     */
    public function GivenOptionsWithReverse_WhenInit_ThenStartReverseGuessGame(array $options)
    {
        $expected = 'Reverse Guess Number (4-digit)';
        $this->sut = new GuessNumberGameEntry($options);

        $this->sut->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }

    /**
     * @return array
     */
    public function optionsWithReverse(): array
    {
        return [
            [
                [
                    'r' => false,
                ],
            ],
            [
                [
                    'reverse' => false,
                ],
            ],
        ];
    }

    /**
     * @test
     *
     * @param array $options
     * @param int $length
     *
     * @dataProvider optionsWithLength
     */
    public function GivenOptionsWithLength_WhenInit_ThenStartGameWithLength(array $options, int $length)
    {
        $expected = "$length-digit";
        $this->sut = new GuessNumberGameEntry($options);

        $this->sut->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }

    /**
     * @return array
     */
    public function optionsWithLength(): array
    {
        return [
            [
                [
                    'l' => 4,
                ],
                4,
            ],
            [
                [
                    'length' => 6,
                ],
                6,
            ],
        ];
    }

    /**
     * @test
     */
    public function GivenOptionsWithInvalidLength_WhenInit_ThenStartGameWithDefaultLength()
    {
        $expected = "4-digit";
        $options = [
            'l' => 10,
        ];
        $this->sut = new GuessNumberGameEntry($options);

        $this->sut->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }

    /**
     * @test
     */
    public function GivenOptionsWithNotSupportedLengthReverseGuessGame_WhenInit_ThenDisplayNotSupportedInfo()
    {
        $expected = 'Reverse Guess Number above 4-digit is not supported';

        $options = [
            'r' => false,
            'l' => 8,
        ];

        $this->sut = new GuessNumberGameEntry($options);

        $this->sut->init();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }

}