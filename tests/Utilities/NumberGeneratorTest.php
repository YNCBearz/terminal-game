<?php

namespace Tests\Utilities;

use App\Utilities\NumberGenerator;
use PHPUnit\Framework\TestCase;

class NumberGeneratorTest extends TestCase
{
    /**
     * @var NumberGenerator $sut
     */
    protected NumberGenerator $sut;

    /**
     * @test
     */
    public function Should_ReturnWithoutRepetition_When_Generate4DigitNumberWithoutRepetitions()
    {
        $this->sut = new NumberGenerator();

        $expected = 4;

        $number = $this->sut->generate4DigitNumberWithoutRepetitions();

        $digits = [];
        $digits[] = ($number / 1000 % 10);
        $digits[] = ($number / 100 % 10);
        $digits[] = ($number / 10 % 10);
        $digits[] = ($number / 1 % 10);

        $uniqueNumbers = array_unique($digits);
        $this->assertEquals(count($uniqueNumbers), $expected, "4-digit number (repetition): $number");
    }
}