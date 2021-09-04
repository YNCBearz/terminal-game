<?php

namespace App\Games\Process;

use App\Elements\WordWithColor;
use App\Utilities\Brush;

class GuessRecordBoard
{
    protected array $records = [];
    protected int $length;

    public function __construct(int $length = 4)
    {
        $this->length = $length;
    }

    public function isRecordsExists(): bool
    {
        return count($this->records) > 0;
    }

    /**
     * @param array $record
     */
    public function pushRecords(array $record)
    {
        $this->records[] = $record;
    }

    public function displayColumns(): void
    {
        $blankTimes = $this->generateBlank(6);

        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor("Guess"),
                new WordWithColor("$blankTimes Result"),
            ]
        );
    }
    
    /**
     * @param int $times
     * @return string
     */
    private function generateBlank(int $times): string
    {
        return str_repeat(' ', $times);
    }
}