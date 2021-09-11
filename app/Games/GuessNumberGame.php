<?php

namespace App\Games;

use App\Elements\GuessRecord;
use App\Enums\Colors\ForegroundColors;
use App\Games\Processes\GuessRecordBoard;
use App\Games\Stats\LeaderBoardStorage;
use App\Helpers\GuessNumberChecker;
use App\Helpers\InputChecker;
use App\Utilities\Brush;
use App\Helpers\NumberGenerator;

class GuessNumberGame
{
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

    public function init()
    {
        $this->pressStart();
        $this->hostGame();
    }

    private function pressStart()
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

            if ($guessNumber == 'exit') {
                return;
            }

            if (!$this->inputChecker->isValid($guessNumber)) {
                $this->displayErrorInputMessage();
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
     * @return bool
     */
    private function isTestingEnv(): bool
    {
        if (!isset($_ENV['APP_ENV'])) {
            $_ENV['APP_ENV'] = getenv('APP_ENV');
        }

        return $_ENV['APP_ENV'] == 'testing';
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

    /**
     * @param array $options
     * @return int
     */
    private function resolveLength(array $options): int
    {
        $default = 4;

        if (isset($options['l']) && $this->isValidLength($options['l'])) {
            return (int)$options['l'];
        }

        if (isset($options['length']) && $this->isValidLength($options['length'])) {
            return (int)$options['length'];
        }

        return $default;
    }

    /**
     * @param string $length
     * @return bool
     */
    private function isValidLength(string $length): bool
    {
        if (!is_numeric($length) || $length < 1 || $length > 10) {
            return false;
        }

        return true;
    }
}
