<?php

namespace Tests\Utilities;

use App\Helpers\DigitChecker;
use PHPUnit\Framework\TestCase;

class DigitCheckerTest extends TestCase
{
    /**
     * @var DigitChecker $sut
     */
    protected DigitChecker $sut;

    public function testBullCounts()
    {
        $secretNumber = 1234;
        $guessNumber = 1567;
        $expected = 1;

        $this->sut = new DigitChecker($secretNumber, $guessNumber);

        $actual = $this->sut->bullCounts();

        $this->assertEquals($actual, $expected);
    }

}