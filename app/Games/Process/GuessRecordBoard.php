<?php

namespace App\Games\Process;

class GuessRecordBoard
{
    protected array $records = [];

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
}