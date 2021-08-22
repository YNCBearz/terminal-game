<?php

namespace Tests\Utilities;

use App\Utilities\DigitGenerator;
use PHPUnit\Framework\TestCase;

class DigitGeneratorTest extends TestCase
{
    /**
     * @var DigitGenerator $sut
     */
    protected DigitGenerator $sut;

    /**
     * @test
     */
    public function Should_ReturnWithoutRepetition_When_Generate4DigitWithoutRepetitions()
    {
        $this->sut = new DigitGenerator();

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