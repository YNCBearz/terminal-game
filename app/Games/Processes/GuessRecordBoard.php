<?php

namespace App\Games\Processes;

use App\Elements\GuessRecord;
use App\Elements\WordWithColor;
use App\Enums\Colors\ForegroundColors;
use App\Utilities\Brush;
use App\Utilities\TypeSetting;

class GuessRecordBoard
{
    protected array $records = [];
    protected int $length;
    protected int $guessTimes = 1;
    protected float $startTime;
    protected float $endTime;

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
        $blankTimes = TypeSetting::generateBlank(6);

        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor("Guess"),
                new WordWithColor("$blankTimes Result"),
            ]
        );
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

        $blankTimes = TypeSetting::generateBlank(11 - $this->length);

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

    public function beginTiming()
    {
        $this->startTime = microtime(true);
    }

    public function stopTiming()
    {
        $this->endTime = microtime(true);
    }

    public function getTiming(): float
    {
        return round($this->endTime - $this->startTime, 2);
    }

    public function toArray(): array
    {
        $length = $this->length;

        return [
            'type' => "Guess Number ($length-digit)",
            'guess_times' => $this->getGuessTimes(),
            'pref' => $this->getTiming(),
        ];
    }

    public function getLength(): int
    {
        return $this->length;
    }
}