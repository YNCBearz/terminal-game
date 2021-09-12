<?php

namespace Tests\Unit\Helpers;

use App\Helpers\NumberGenerator;
use PHPUnit\Framework\TestCase;

class NumberGeneratorTest extends TestCase
{
    protected NumberGenerator $sut;

    /**
     * @test
     */
    public function Should_ReturnWithoutRepetition_When_GenerateDigitNumberWithoutRepetitions()
    {
        $length = 5;
        $expected = 5;

        $this->sut = new NumberGenerator($length);

        $number = $this->sut->generateDigitNumberWithoutRepetitions();

        $digits = str_split($number);

        $uniqueNumbers = array_unique($digits);
        $this->assertEquals(count($uniqueNumbers), $expected, "$length-digit number (repetition): $number");
    }


    /**
     * @test
     *
     * @param int $length
     * @param int $expectedCount
     *
     * @dataProvider eachLengthCountOfNumber
     */
    public function Should_ReturnCorrectCountOfNumberWithoutRepetition_When_GenerateAllPossibleDigitNumber(
        int $length,
        int $expectedCount
    ) {
        $this->sut = new NumberGenerator($length);

        $possibleNumbers = $this->sut->generateAllPossibleDigitNumber();

        $this->assertEquals(count($possibleNumbers), $expectedCount);
    }

    public function eachLengthCountOfNumber(): array
    {
        return [
            [1, 10],
            [2, 10 * 9],
        ];
    }
}