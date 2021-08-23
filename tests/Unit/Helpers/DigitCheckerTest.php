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
     * @dataProvider bullCountsCase
     */
    public function testBullCounts($secretNumber, $guessNumber, $expected)
    {
        $this->sut = new DigitChecker($secretNumber, $guessNumber);

        $actual = $this->sut->bullCounts();
        $this->assertEquals($actual, $expected);
    }

    public function bullCountsCase(): array
    {
        return [
            [
                1234,
                1567,
                1,
            ],
        ];
    }

    /**
     * @dataProvider cowCountsCase
     */
    public function testCowCounts($secretNumber, $guessNumber, $expected)
    {
        $this->sut = new DigitChecker($secretNumber, $guessNumber);

        $actual = $this->sut->cowCounts();
        $this->assertEquals($actual, $expected);
    }

    public function cowCountsCase(): array
    {
        return [
            [
                1234,
                1567,
                0,
            ],
        ];
    }
}