<?php

namespace Tests\Unit\Helpers;

use App\Helpers\DigitChecker;
use PHPUnit\Framework\TestCase;

class DigitCheckerTest extends TestCase
{
    /**
     * @var DigitChecker $sut
     */
    protected DigitChecker $sut;

    /**
     * @param int $secretNumber
     * @param int $guessNumber
     * @param string $expected
     *
     * @dataProvider digitsCase
     */
    public function testGetResult(int $secretNumber, int $guessNumber, string $expected)
    {
        $this->sut = new DigitChecker($secretNumber, $guessNumber);

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
                1234,
                1256,
                '2A0B',
            ],
            [
                1234,
                5678,
                '0A0B',
            ],
        ];
    }
}