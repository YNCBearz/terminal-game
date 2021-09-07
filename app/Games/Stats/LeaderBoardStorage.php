<?php

namespace App\Games\Stats;

use App\Enums\Colors\ForegroundColors;
use App\Games\Processes\GuessRecordBoard;
use App\Utilities\Brush;

class LeaderBoardStorage
{
    protected GuessRecordBoard $guessRecordBoard;

    public function __construct(GuessRecordBoard $guessRecordBoard)
    {
        $this->guessRecordBoard = $guessRecordBoard;
    }

    public function askIfStats()
    {
        Brush::paintOnConsole("Do you want to save to leaderboard? (Y/N) \n", ForegroundColors::GREEN);
        $input = readline("> ");

        if ($this->wantToSave($input)) {
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
        $file = fopen( "./storages/Stats/bearFile.txt", "w");
        $text = 'Hello World';
        fwrite($file, $text);
        $text = 'Good night!';
        fwrite($file, $text);
        fclose($file);
    }
}