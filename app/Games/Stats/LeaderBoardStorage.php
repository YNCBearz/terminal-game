<?php

namespace App\Games\Stats;

use App\Elements\WordWithColor;
use App\Enums\Colors\ForegroundColors;
use App\Games\Processes\GuessRecordBoard;
use App\Utilities\Brush;
use App\Utilities\TypeSetting;

class LeaderBoardStorage
{
    protected GuessRecordBoard $guessRecordBoard;
    protected string $name = 'anonymous';
    protected string $fileName = 'leaderboard.json';
    protected string $recordUUId;

    /**
     * NOTE.
     * $nameLength must be greater than or equal to $columnBlankTimes
     */
    protected int $nameLength = 12;
    protected int $columnBlankTimes = 11;
    protected int $columnLargeBlankTimes = 16;

    public function __construct(GuessRecordBoard $guessRecordBoard)
    {
        $this->guessRecordBoard = $guessRecordBoard;
    }

    public function askIfStats()
    {
        Brush::paintOnConsole("Do you want to save to leaderboard? (Y/N)", ForegroundColors::GREEN);
        $input = readline("> ");
        echo PHP_EOL;

        if ($this->wantToSave($input)) {
            $this->askForName();
            $this->save();
            $this->displayRank();
        }

        Brush::paintOnConsole("ʕ •ᴥ•ʔ：Thank you for playing.", ForegroundColors::BROWN);
    }

    public function wantToSave(string $input): bool
    {
        $input = strtolower($input);
        if ($input == 'yes' || $input == 'y') {
            return true;
        }

        return false;
    }

    public function save()
    {
        $records = $this->pushToRecords();

        $filename = $this->getRecordsFileName();
        $file = fopen($filename, "w");

        $text = json_encode($records);

        fwrite($file, $text);
        fclose($file);
    }

    private function askForName(): void
    {
        Brush::paintOnConsole("Please input your name: ", ForegroundColors::CYAN);
        $this->name = readline("> ") ?? 'anonymous';
        echo PHP_EOL;
    }

    /**
     * @return array
     */
    private function generateRecordData(): array
    {
        $record = $this->guessRecordBoard->toArray();

        return array_merge($record, [
            'name' => $this->name,
            'uuid' => uniqid(),
        ]);
    }

    /**
     * @param string $filename
     * @return array
     */
    private function getPreviousRecords(string $filename): array
    {
        if (!file_exists($filename)) {
            return [];
        }

        return json_decode(file_get_contents($filename), true);
    }

    /**
     * @return string
     */
    private function getRecordsFileName(): string
    {
        $storagePath = $_ENV['STORAGE_PATH'];

        return $storagePath."/".$this->fileName;
    }

    private function recordType(): string
    {
        $length = $this->guessRecordBoard->getLength();

        return "$length-digit";
    }

    private function pushToRecords(): array
    {
        $filename = $this->getRecordsFileName();
        $records = $this->getPreviousRecords($filename);

        $record = $this->generateRecordData();
        $this->recordUUId = $record['uuid'];

        $recordType = $this->recordType();
        $records[$recordType][] = $record;

        return $records;
    }

    private function displayRank()
    {
        $filename = $this->getRecordsFileName();
        $records = $this->getPreviousRecords($filename);

        $recordType = $this->recordType();
        $collection = collect($records[$recordType]);

        $sorted = $collection->sortBy(['perf', 'guess_times']);

        $this->displayColumns();

        $sorted->every(function ($record, $rank) {
            $rank = $rank + 1;
            $name = substr($record['name'], 0 , $this->nameLength);
            $pref = $record['pref'] . ' seconds';
            $guessTimes = $record['guess_times'];

            $recordBlankTimes = $this->columnBlankTimes + 3;
            $recordLargeBlankTimes = $this->columnLargeBlankTimes + 3;

            $blankBetweenRankAndName = TypeSetting::generateBlank($recordBlankTimes - strlen($rank));
            $blankBetweenNameAndPref = TypeSetting::generateBlank($recordBlankTimes - strlen($name));
            $blankBetweenPrefAndGuessTimes = TypeSetting::generateBlank($recordLargeBlankTimes - strlen($pref));

            Brush::paintOnConsole(
                "$rank $blankBetweenRankAndName $name $blankBetweenNameAndPref $pref $blankBetweenPrefAndGuessTimes $guessTimes",
                ($record['uuid'] == $this->recordUUId) ? ForegroundColors::RED : ForegroundColors::GREEN
            );

            return true;
        });

        echo PHP_EOL;
    }

    public function displayColumns()
    {
        $blank = TypeSetting::generateBlank($this->columnBlankTimes);
        $largeBlank = TypeSetting::generateBlank($this->columnLargeBlankTimes);

        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor("Rank"),
                new WordWithColor("$blank Name"),
                new WordWithColor("$blank Perf"),
                new WordWithColor("$largeBlank Guess Times"),
            ]
        );
    }
}