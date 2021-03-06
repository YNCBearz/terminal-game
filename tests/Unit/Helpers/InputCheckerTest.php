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

        $actual = $this->sut->isValidGuessNumber($guessNumber);

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

        $actual = $this->sut->isValidGuessNumber($guessNumber);

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

        $actual = $this->sut->isValidGuessNumber($guessNumber);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     *
     * @param int $length
     * @param string $guessResult
     *
     * @dataProvider notFormatGuessResult
     */
    public function GivenNotFormatGuessResult_WhenIsValidGuessResult_ReturnFalse(int $length, string $guessResult)
    {
        $this->sut = new InputChecker($length);

        $actual = $this->sut->isValidGuessResult($guessResult);

        $this->assertFalse($actual, "Not valid guess result: $guessResult ($length-digit)");
    }

    /**
     * @test
     *
     * @param int $length
     * @param string $guessResult
     *
     * @dataProvider formatGuessResult
     */
    public function GivenFormatGuessResult_WhenIsValidGuessResult_ReturnTrue(int $length, string $guessResult)
    {
        $this->sut = new InputChecker($length);

        $actual = $this->sut->isValidGuessResult($guessResult);

        $this->assertTrue($actual, "Valid guess result: $guessResult ($length-digit)");
    }

    public function notFormatGuessResult(): array
    {
        return [
            [4, 'aabb'],
            [4, '123'],
            [4, '...'],
            [4, '1234'],
            [4, '1atb'],
            [4, '0a5b'],
        ];
    }

    public function formatGuessResult(): array
    {
        return [
            [4, '0A1b'],
            [4, '1a1b'],
        ];
    }

}