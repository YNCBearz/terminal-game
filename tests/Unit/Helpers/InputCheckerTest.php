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
        $guessNumber = '123';
        $expected = false;

        $actual = $this->sut->isValid($guessNumber);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function GivenNotNumeric_WhenIsValid_ReturnFalse()
    {
        $this->sut = new InputChecker(4);
        $guessNumber = 'bear';
        $expected = false;

        $actual = $this->sut->isValid($guessNumber);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function GivenNotUniqueNumber_WhenIsValid_ReturnFalse()
    {
        $this->sut = new InputChecker(5);
        $guessNumber = '11123';
        $expected = false;

        $actual = $this->sut->isValid($guessNumber);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function GivenNotFormatGuessResult_WhenIsValidGuessResult_ReturnFalse()
    {
        $this->sut = new InputChecker(5);
        $guessResult = 'aabb';

        $actual = $this->sut->isValidGuessResult($guessResult);

        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function GivenFormatGuessResult_WhenIsValidGuessResult_ReturnTrue()
    {
        $this->sut = new InputChecker(5);
        $guessResult = '0a1b';

        $actual = $this->sut->isValidGuessResult($guessResult);

        $this->assertTrue($actual);
    }

}