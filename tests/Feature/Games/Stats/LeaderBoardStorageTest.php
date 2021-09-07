<?php

namespace Tests\Feature\Games\Stats;

use App\Games\Stats\LeaderBoardStorage;
use PHPUnit\Framework\TestCase;

class LeaderBoardStorageTest extends TestCase
{
    protected LeaderBoardStorage $sut;

    /**
     * @test
     *
     * @dataProvider inputYes
     */
    public function GivenYesInput_WhenWantToSave_ThenReturnTrue($input)
    {
        $this->sut = new LeaderBoardStorage();

        $actual = $this->sut->wantToSave($input);

        $this->assertTrue($actual, "Failed when input: $input");
    }

    public function inputYes(): array
    {
        return [
            ['Y'],
            ['Yes'],
            ['y'],
            ['yes'],
        ];
    }

}