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

        $fourDigits = $this->sut->generate4DigitWithoutRepetitions();

        $selectedNumbers = [];
        $selectedNumbers[] = ($fourDigits / 1000 % 10);
        $selectedNumbers[] = ($fourDigits / 100 % 10);
        $selectedNumbers[] = ($fourDigits / 10 % 10);
        $selectedNumbers[] = ($fourDigits / 1 % 10);

        $uniqueNumbers = array_unique($selectedNumbers);
        $this->assertEquals(count($uniqueNumbers), $expected, "4-digit number (repetition): $fourDigits");
    }

    /**
     * @test
     */
    public function Should_Return4Digit_When_Generate4DigitWithoutRepetitions()
    {
        $expected = 4;

        $this->sut = new DigitGenerator();

        $actual = $this->sut->generate4DigitWithoutRepetitions();

        $this->assertEquals($expected, strlen((string)$actual));
    }

}