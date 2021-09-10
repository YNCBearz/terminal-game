<?php

namespace Tests\Unit\Helpers;

use App\Helpers\GuessNumberChecker;
use PHPUnit\Framework\TestCase;

class GuessNumberCheckerTest extends TestCase
{
    /**
     * @var GuessNumberChecker $sut
     */
    protected GuessNumberChecker $sut;

    /**
     * @param string $secretNumber
     * @param string $guessNumber
     * @param string $expected
     *
     * @dataProvider digitsCase
     */
    public function testGetResult(string $secretNumber, string $guessNumber, string $expected)
    {
        $this->sut = new GuessNumberChecker($secretNumber, $guessNumber);

        $actual = $this->sut->getResult();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function digitsCase(): array
    {
        return [
            [
                "1234",
                "1256",
                '2A0B',
            ],
            [
                "1234",
                "5678",
                '0A0B',
            ],
            [
                "1234",
                "1324",
                '2A2B',
            ],
            [
                "1234",
                "1234",
                '4A0B',
            ],
            [
                "1357",
                "2413",
                '0A2B',
            ],
            [
                "1234",
                "1342",
                '1A3B',
            ],
        ];
    }


}