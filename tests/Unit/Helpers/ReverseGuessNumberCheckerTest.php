<?php

namespace Tests\Unit\Helpers;

use App\Helpers\ReverseGuessNumberChecker;
use PHPUnit\Framework\TestCase;

class ReverseGuessNumberCheckerTest extends TestCase
{
    protected ReverseGuessNumberChecker $sut;

    /**
     * @test
     *
     * @param string $guessNumber
     * @param string $guessResult
     * @param string $number
     *
     * @dataProvider fitNumberTestCase
     */
    public function GivenFitNumber_WhenIsFitNumber_ReturnTrue(string $guessNumber, string $guessResult, string $number)
    {
        $this->sut = new ReverseGuessNumberChecker($guessNumber, $guessResult);

        $actual = $this->sut->isFitNumber($number);

        $this->assertTrue($actual, "Fit number: $number (guess number: $guessNumber | guess result: $guessResult)");
    }

    public function fitNumberTestCase(): array
    {
        return [
            ['1', '0A0B', '0'],
        ];
    }

}