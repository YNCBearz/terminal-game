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
     *
     * @param string $guessResult
     *
     * @dataProvider notFormatGuessResult
     */
    public function GivenNotFormatGuessResult_WhenIsValidGuessResult_ReturnFalse($guessResult)
    {
        $this->sut = new InputChecker(5);

        $actual = $this->sut->isValidGuessResult($guessResult);

        $this->assertFalse($actual);
    }

    /**
     * @test
     *
     * @param string $guessResult
     *
     * @dataProvider formatGuessResult
     */
    public function GivenFormatGuessResult_WhenIsValidGuessResult_ReturnTrue(string $guessResult)
    {
        $this->sut = new InputChecker(5);

        $actual = $this->sut->isValidGuessResult($guessResult);

        $this->assertTrue($actual);
    }

    public function notFormatGuessResult(): array
    {
        return [
            ['aabb'],
            ['123'],
            ['...'],
            ['1234'],
            ['1atb'],
        ];
    }

    public function formatGuessResult(): array
    {
        return [
            ['0A1b'],
            ['1a1b'],
        ];
    }

}