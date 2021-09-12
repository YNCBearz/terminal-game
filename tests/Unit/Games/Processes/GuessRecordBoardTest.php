<?php

namespace Tests\Feature\Games\Processes;

use App\Elements\GuessRecord;
use App\Games\Processes\GuessRecordBoard;
use PHPUnit\Framework\TestCase;

class GuessRecordBoardTest extends TestCase
{
    protected GuessRecordBoard $sut;

    protected function setUp(): void
    {
        parent::setUp();
        ob_start();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        ob_end_clean();
    }

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

    public function testDisplayColumns()
    {
        $expected = 'Guess';

        $this->sut = new GuessRecordBoard();

        $this->sut->displayColumns();
        $actual = $this->getActualOutput();

        $this->assertStringContainsString($expected, $actual);
    }
}