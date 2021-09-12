<?php

namespace App\Games;

use App\Elements\GuessRecord;
use App\Enums\Colors\ForegroundColors;
use App\Games\Contracts\Gameable;
use App\Games\Processes\GuessRecordBoard;
use App\Games\Stats\LeaderBoardStorage;
use App\Games\Traits\GameLengthTrait;
use App\Games\Traits\TestingEnvTrait;
use App\Helpers\GuessNumberChecker;
use App\Helpers\InputChecker;
use App\Utilities\Brush;
use App\Helpers\NumberGenerator;

class GuessNumberGame implements Gameable
{
    use GameLengthTrait;
    use TestingEnvTrait;

    protected array $options;

    protected int $length;
    protected NumberGenerator $numberGenerator;
    protected InputChecker $inputChecker;
    protected GuessRecordBoard $guessRecordBoard;

    public function __construct(array $options)
    {
        $this->options = $options;

        $this->length = $this->resolveLength($options);

        $this->numberGenerator = new NumberGenerator($this->length);
        $this->inputChecker = new InputChecker($this->length);
        $this->guessRecordBoard = new GuessRecordBoard($this->length);
    }

    public function start()
    {
        $this->displayGameInfo();
        $this->hostGame();
    }

    private function displayGameInfo()
    {
        $length = $this->length;

        Brush::paintOnConsole("Guess Number ($length-digit)", ForegroundColors::WHITE);
        echo PHP_EOL;
        Brush::paintOnConsole("Description:", ForegroundColors::BROWN);
        Brush::paintOnConsole("  You must guess a $length-digit secret number selected by the computer");
        echo PHP_EOL;
        Brush::paintOnConsole("Please enter a $length-digit number:", ForegroundColors::GREEN);
    }

    private function hostGame()
    {
        if ($this->isTestingEnv()) {
            return;
        }

        $secretNumber = $this->numberGenerator->generateDigitNumberWithoutRepetitions();

        $guessResult = '0A0B';

        while (!$this->isGameSet($guessResult)) {
            $guessNumber = readline("> ");
            $guessNumber = strtoupper($guessNumber);

            if ($guessNumber == 'EXIT') {
                return;
            }

            if (!$this->inputChecker->isValidGuessNumber($guessNumber)) {
                $this->displayErrorInputMessage();
                echo PHP_EOL;
                continue;
            }

            $guessResult = $this->getGuessResult($secretNumber, $guessNumber);

            if (!$this->guessRecordBoard->isRecordsExists()) {
                $this->guessRecordBoard->beginTiming();
            }

            if ($this->isGameSet($guessResult)) {
                $this->guessRecordBoard->stopTiming();
                $this->displayGameSetInfo();

                $leaderBoardStorage = new LeaderBoardStorage($this->guessRecordBoard);
                $leaderBoardStorage->askIfStats();

                return;
            }

            $this->guessRecordBoard->displayColumns();

            if ($this->guessRecordBoard->isRecordsExists()) {
                $this->guessRecordBoard->displayRecords();
            }

            $record = new GuessRecord($guessNumber, $guessResult);

            $this->guessRecordBoard->displayRecord($record);
            $this->guessRecordBoard->writeDownRecord($record);
        }
    }

    /**
     * @param string $guessResult
     * @return bool
     */
    private function isGameSet(string $guessResult): bool
    {
        $length = $this->length;

        return $guessResult == $length.'A0B';
    }

    private function displayGameSetInfo(): void
    {
        $guessTimes = $this->guessRecordBoard->getGuessTimes();
        $timing = $this->guessRecordBoard->getTiming();

        echo PHP_EOL;
        Brush::paintOnConsole(
            "You win! (perf: $timing seconds | guess times: $guessTimes) \n",
            ForegroundColors::BROWN
        );
    }

    /**
     * @param string $secretNumber
     * @param string $guessNumber
     * @return string
     */
    private function getGuessResult(string $secretNumber, string $guessNumber): string
    {
        $guessGameChecker = new GuessNumberChecker($secretNumber, $guessNumber);

        return $guessGameChecker->getResult();
    }

    private function displayErrorInputMessage(): void
    {
        $length = $this->length;
        Brush::paintOnConsole(
            "Please enter a $length-digit number (digits must be all different):",
            ForegroundColors::RED
        );
    }
}
