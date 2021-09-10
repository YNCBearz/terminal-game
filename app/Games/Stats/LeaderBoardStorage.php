<?php

namespace App\Games\Stats;

use App\Enums\Colors\ForegroundColors;
use App\Games\Processes\GuessRecordBoard;
use App\Utilities\Brush;

class LeaderBoardStorage
{
    protected GuessRecordBoard $guessRecordBoard;
    protected string $name = 'anonymous';
    protected string $fileName = 'leaderboard.json';
    protected string $recordUUId;

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
        $filename = $this->getRecordsFileName();

        $records = $this->getPreviousRecords($filename);
        $record = $this->generateRecordData();
        $this->recordUUId = $record['uuid'];

        $recordType = $this->recordType();
        $records[$recordType][] = $record;

        $file = fopen($filename, "w");

        $text = json_encode($records);

        fwrite($file, $text);
        fclose($file);
    }

    private function askForName(): void
    {
        Brush::paintOnConsole("Please input your name:\n", ForegroundColors::CYAN);
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
}