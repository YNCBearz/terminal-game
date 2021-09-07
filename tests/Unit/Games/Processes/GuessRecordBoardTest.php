<?php

namespace Tests\Unit\Games\Processes;

use App\Elements\GuessRecord;
use App\Games\Processes\GuessRecordBoard;
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
        $record = new GuessRecord('1234', '0A2B');
        $this->sut->pushRecords($record);

        $actual = $this->sut->isRecordsExists();

        $this->assertTrue($actual);
    }
}