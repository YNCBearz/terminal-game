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

        $digits = [];
        $digits[] = ($number / 1000 % 10);
        $digits[] = ($number / 100 % 10);
        $digits[] = ($number / 10 % 10);
        $digits[] = ($number / 1 % 10);

        $uniqueNumbers = array_unique($digits);
        $this->assertEquals(count($uniqueNumbers), $expected, "4-digit number (repetition): $number");
    }
}