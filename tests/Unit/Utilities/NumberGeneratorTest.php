<?php

namespace Tests\Unit\Utilities;

use App\Utilities\NumberGenerator;
use PHPUnit\Framework\TestCase;

class NumberGeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function Should_ReturnWithoutRepetition_When_Generate4DigitNumberWithoutRepetitions()
    {
        $expected = 4;

        $number = NumberGenerator::generate4DigitNumberWithoutRepetitions();

        $digits = str_split($number);

        $uniqueNumbers = array_unique($digits);
        $this->assertEquals(count($uniqueNumbers), $expected, "4-digit number (repetition): $number");
    }
}