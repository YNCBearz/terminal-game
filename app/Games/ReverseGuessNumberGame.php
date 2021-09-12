<?php

namespace App\Games;

use App\Elements\GuessRecord;
use App\Enums\Colors\ForegroundColors;
use App\Games\Contracts\Gameable;
use App\Games\Processes\GuessRecordBoard;
use App\Games\Traits\GameLengthTrait;
use App\Games\Traits\TestingEnvTrait;
use App\Helpers\GuessNumberChecker;
use App\Helpers\InputChecker;
use App\Helpers\NumberGenerator;
use App\Utilities\Brush;

class ReverseGuessNumberGame implements Gameable
{
    use GameLengthTrait;
    use TestingEnvTrait;

    protected array $options;
    protected int $length;
    protected NumberGenerator $numberGenerator;
    protected InputChecker $inputChecker;
    protected GuessRecordBoard $guessRecordBoard;

    protected array $possibleNumbers;
    protected int $maxSupportedLength = 6;

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
        if ($this->isNotSupportedLength()) {
            $this->displayNotSupportedInfo();

            return;
        }

        $this->displayGameInfo();
        $this->hostGame();
    }

    private function displayGameInfo()
    {
        $length = $this->length;

        Brush::paintOnConsole("Reverse Guess Number ($length-digit)", ForegroundColors::WHITE);
        echo PHP_EOL;
        Brush::paintOnConsole("Description:", ForegroundColors::BROWN);
        Brush::paintOnConsole("  Set a $length-digit secret number, and computer will guess the secret number");
        echo PHP_EOL;
    }

    private function hostGame()
    {
        if ($this->isTestingEnv()) {
            return;
        }

        $this->possibleNumbers = $this->numberGenerator->generateAllPossibleDigitNumber();

        $guessResult = '0A0B';

        while (!$this->isGameSet($guessResult)) {
            $guessNumber = $this->resolveGuessNumber();

            $this->displayGuessNumber($guessNumber);
            $this->askForGuessResult();

            $guessResult = readline("> ");
            $guessResult = strtoupper($guessResult);
            echo PHP_EOL;

            if ($guessResult == 'EXIT') {
                return;
            }

            if (!$this->inputChecker->isValidGuessResult($guessResult)) {
                $this->displayErrorInputMessage();
                continue;
            }

            if (!$this->guessRecordBoard->isRecordsExists()) {
                $this->guessRecordBoard->beginTiming();
            }

            if ($this->isGameSet($guessResult)) {
                $this->guessRecordBoard->stopTiming();
                $this->displayGameSetInfo();

                return;
            }

            $this->filterPossibleNumbersWithGameResult($guessNumber, $guessResult);

            $this->guessRecordBoard->displayColumns();

            if ($this->guessRecordBoard->isRecordsExists()) {
                $this->guessRecordBoard->displayRecords();
            }

            $record = new GuessRecord($guessNumber, $guessResult);

            $this->guessRecordBoard->displayRecord($record);
            $this->guessRecordBoard->writeDownRecord($record);

            echo PHP_EOL;

            if ($this->isNoPossibleNumbers()) {
                $this->displayGameOverInfo();

                return;
            }
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

    /**
     * @param string $guessNumber
     */
    private function displayGuessNumber(string $guessNumber)
    {
        echo PHP_EOL;

        $probability = round(1 / count($this->possibleNumbers), 2) * 100;
        $displayOfProbability = ($probability > 0) ? "($probability%)" : '';

        Brush::paintOnConsole(
            "ʕ •ᴥ•ʔ： $guessNumber? $displayOfProbability",
            ForegroundColors::BROWN
        );

        echo PHP_EOL;
    }

    private function displayErrorInputMessage()
    {
        Brush::paintOnConsole(
            "Please check your input: (format must like 0A1B)",
            ForegroundColors::RED
        );
    }

    private function askForGuessResult()
    {
        Brush::paintOnConsole("Please enter a guess result: ", ForegroundColors::GREEN);
    }

    private function displayGameSetInfo()
    {
        $guessTimes = $this->guessRecordBoard->getGuessTimes();

        Brush::paintOnConsole("ʕ •ᴥ•ʔ：Thank you for playing. (guess times: $guessTimes)", ForegroundColors::BROWN);
    }

    /**
     * @param string $guessNumber
     * @param string $guessResult
     */
    private function filterPossibleNumbersWithGameResult(string $guessNumber, string $guessResult)
    {
        $possibleNumbers = $this->possibleNumbers;

        $result = [];
        foreach ($possibleNumbers as $compareNumber) {
            $guessNumberChecker = new GuessNumberChecker($compareNumber, $guessNumber);
            $compareResult = $guessNumberChecker->getResult();

            if ($compareResult == $guessResult) {
                $result[] = $compareNumber;
            }
        }

        $this->possibleNumbers = $result;
    }

    private function displayGameOverInfo(): void
    {
        Brush::paintOnConsole(
            "There are something wrong with the guess results you input before.",
            ForegroundColors::RED
        );
    }

    /**
     * @return bool
     */
    private function isNoPossibleNumbers(): bool
    {
        return count($this->possibleNumbers) == 0;
    }

    /**
     * @return bool
     */
    private function isNotSupportedLength(): bool
    {
        return $this->length > $this->maxSupportedLength;
    }

    private function displayNotSupportedInfo(): void
    {
        Brush::paintOnConsole(
            "Sorry, Reverse Guess Number above 4-digit is not supported right now.",
            ForegroundColors::LIGHT_PURPLE
        );
    }

    /**
     * @return string
     */
    private function resolveGuessNumber(): string
    {
        $guessNumber = (string)$this->possibleNumbers[0];

        return $guessNumber;
    }
}