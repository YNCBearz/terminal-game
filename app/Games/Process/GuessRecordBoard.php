<?php

namespace App\Games\Process;

use App\Elements\GuessRecord;
use App\Elements\WordWithColor;
use App\Enums\Colors\ForegroundColors;
use App\Utilities\Brush;

class GuessRecordBoard
{
    protected array $records = [];
    protected int $length;
    protected int $guessTimes = 1;

    public function __construct(int $length = 4)
    {
        $this->length = $length;
    }

    public function isRecordsExists(): bool
    {
        return count($this->records) > 0;
    }

    /**
     * @param GuessRecord $record
     */
    public function pushRecords(GuessRecord $record)
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

    public function displayRecords(): void
    {
        foreach ($this->records as $record) {
            $this->displayRecord($record);
        }
    }

    /**
     * @param GuessRecord $record
     */
    public function displayRecord(GuessRecord $record): void
    {
        $guessNumber = $record->guessNumber;
        $guessResult = $record->guessResult;

        $blankTimes = $this->generateBlank(11 - $this->length);

        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor("$guessNumber", ForegroundColors::CYAN),
                new WordWithColor("$blankTimes $guessResult", ForegroundColors::LIGHT_RED),
            ]
        );
    }

    /**
     * @param GuessRecord $record
     */
    public function writeDownRecord(GuessRecord $record)
    {
        $this->pushRecords($record);
        $this->guessTimes++;
    }

    public function getGuessTimes(): int
    {
        return $this->guessTimes;
    }
}