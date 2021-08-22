<?php

namespace Tests\Utilities;

use App\Utilities\NumberConverter;
use PHPUnit\Framework\TestCase;

class NumberConverterTest extends TestCase
{
    /**
     * @var NumberConverter $sut
     */
    protected NumberConverter $sut;

    public function testConvertToDigit()
    {
        $number = 1234;
        $expected = [1,2,3,4];

        $actual = $this->sut->convertToDigits($number);

        $this->assertEquals($expected, $actual);

    }

}