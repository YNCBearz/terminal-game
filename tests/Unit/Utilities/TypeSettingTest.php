<?php

namespace Tests\Unit\Utilities;

use App\Utilities\TypeSetting;
use PHPUnit\Framework\TestCase;

class TypeSettingTest extends TestCase
{
    public function testGenerateBlank()
    {
        $expected = '  ';
        $times = 2;

        $actual = TypeSetting::generateBlank($times);

        $this->assertEquals($actual, $expected);
    }

}