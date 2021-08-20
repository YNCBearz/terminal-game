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
    public function Should_Return4Digit_When_Generate4DigitWithoutRepetitions()
    {
        $this->sut = new NumberGenerator();

        $actual = $this->sut->generate4DigitWithoutRepetitions();

        $this->assertGreaterThan(999, $actual);
        $this->assertLessThan(10000, $actual);
    }
}