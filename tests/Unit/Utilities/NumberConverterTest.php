<?php

namespace Tests\Unit\Utilities;

use App\Utilities\NumberConverter;
use PHPUnit\Framework\TestCase;

class NumberConverterTest extends TestCase
{
    /**
     * @param string $number
     * @param array $expected
     * @dataProvider toDigitsCase
     */
    public function testToDigits(string $number, array $expected)
    {
        $this->digitsShouldBe($number, $expected);
    }

    /**
     * @return array
     */
    public function toDigitsCase(): array
    {
        return [
            [
                "1234",
                [1, 2, 3, 4],
            ],
            [
                "13579",
                [1, 3, 5, 7, 9],
            ],
            [
                "0135",
                [0, 1, 3, 5],
            ],
            [
                "0789",
                [0, 7, 8, 9],
            ],
        ];
    }

    /**
     * @param string $number
     * @param array $expected
     */
    private function digitsShouldBe(string $number, array $expected): void
    {
        $actual = NumberConverter::toDigits($number);
        $this->assertEquals($expected, $actual);
    }

}