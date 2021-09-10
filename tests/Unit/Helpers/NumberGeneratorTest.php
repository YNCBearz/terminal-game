<?php

namespace Tests\Unit\Helpers;

use App\Utilities\NumberGenerator;
use PHPUnit\Framework\TestCase;

class NumberGeneratorTest extends TestCase
{
    protected NumberGenerator $sut;

    /**
     * @test
     */
    public function Should_ReturnWithoutRepetition_When_Generate4DigitNumberWithoutRepetitions()
    {
        $length = 5;
        $expected = 5;

        $this->sut = new NumberGenerator($length);

        $number = $this->sut->generateDigitNumberWithoutRepetitions();

        $digits = str_split($number);

        $uniqueNumbers = array_unique($digits);
        $this->assertEquals(count($uniqueNumbers), $expected, "$length-digit number (repetition): $number");
    }
}