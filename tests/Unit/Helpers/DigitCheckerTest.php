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

    public function testCowCounts()
    {
        $secretNumber = 1234;
        $guessNumber = 1567;
        $expected = 0;

        $this->sut = new DigitChecker($secretNumber, $guessNumber);

        $actual = $this->sut->cowCounts();
        $this->assertEquals($actual, $expected);
    }
}