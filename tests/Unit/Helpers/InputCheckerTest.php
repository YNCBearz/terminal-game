<?php

namespace Tests\Unit\Helpers;

use App\Helpers\InputChecker;
use PHPUnit\Framework\TestCase;

class InputCheckerTest extends TestCase
{
    protected InputChecker $sut;

    /**
     * @test
     */
    public function GivenWrongLengthNumber_WhenIsValid_ReturnFalse()
    {
        $this->sut = new InputChecker(4);
        $guessNumber = 123;
        $expected = false;

        $actual = $this->sut->isValid($guessNumber);

        $this->assertEquals($expected, $actual);
    }


}