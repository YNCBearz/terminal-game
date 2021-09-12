<?php

namespace Tests\Unit\Helpers;

use App\Helpers\ReverseGuessNumberChecker;
use PHPUnit\Framework\TestCase;

class ReverseGuessNumberCheckerTest extends TestCase
{
    protected ReverseGuessNumberChecker $sut;

    /**
     * @test
     */
    public function GivenFitNumber_WhenIsFitNumber_ReturnTrue()
    {
        $guessNumber = 0;
        $guessResult = '0A0B';

        $number = '1';

        $this->sut = new ReverseGuessNumberChecker($guessNumber, $guessResult);

        $actual = $this->sut->isFitNumber($number);

        $this->assertTrue($actual);
    }

}