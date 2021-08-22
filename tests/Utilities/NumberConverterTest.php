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

    /**
     * @param int $number
     * @param array $expected
     * @dataProvider toDigitsCase
     */
    public function testToDigits(int $number, array $expected)
    {
        $this->sut = new NumberConverter();

        $this->digitsShouldBe($number, $expected);
    }

    /**
     * @return array
     */
    public function toDigitsCase(): array
    {
        return [
            [
                1234,
                [1, 2, 3, 4],
            ],
        ];
    }

    /**
     * @param int $number
     * @param array $expected
     */
    private function digitsShouldBe(int $number, array $expected): void
    {
        $actual = $this->sut->toDigits($number);
        $this->assertEquals($expected, $actual);
    }

}