<?php

namespace Tests\Unit\Games\Process;

use App\Games\Process\GuessRecordBoard;
use PHPUnit\Framework\TestCase;

class GuessRecordBoardTest extends TestCase
{
    protected GuessRecordBoard $sut;

    /**
     * @test
     */
    public function GivenNewGuessRecordBoard_WhenIsRecordsExists_ReturnFalse()
    {
        $this->sut = new GuessRecordBoard();

        $actual = $this->sut->isRecordsExists();

        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function GivenGuessRecordBoardWithRecords_WhenIsRecordsExists_ReturnFalse()
    {
        $this->sut = new GuessRecordBoard();
        $this->sut->pushRecords(['1234' => '0A2B']);

        $actual = $this->sut->isRecordsExists();

        $this->assertTrue($actual);
    }
}