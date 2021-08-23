<?php

namespace App\Games;

use App\Elements\WordWithColor;
use App\Enums\Colors\ForegroundColors;
use App\Helpers\DigitChecker;
use App\Utilities\Brush;
use App\Utilities\NumberGenerator;

class GuessNumberGame
{
    protected array $options;
    protected bool $isDisplayForHelp;

    protected array $guessRecords = [];
    protected int $guessTimes = 1;

    public function __construct(array $options)
    {
        $this->options = $options;

        $this->isDisplayForHelp = isset($options['help']) || isset($options['h']);
    }

    public function init()
    {
        if ($this->isDisplayForHelp) {
            $this->displayForHelp();

            return;
        }

        $this->pressStart();

        $this->hostGame();
    }

    private function displayForHelp(): void
    {
        Brush::paintOnConsole("Description:", ForegroundColors::BROWN);
        Brush::paintOnConsole("  Display help for a command");
        echo PHP_EOL;
        Brush::paintOnConsole("Options", ForegroundColors::BROWN);
        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor("  -h, --help", ForegroundColors::GREEN),
                new WordWithColor("     Display help for the given command."),
            ]
        );
    }

    private function pressStart()
    {
        Brush::paintOnConsole("Guess Number (4-digit)", ForegroundColors::WHITE);
        echo PHP_EOL;
        Brush::paintOnConsole("Description:", ForegroundColors::BROWN);
        Brush::paintOnConsole("  You must guess a 4-digit secret number selected by the computer");
        echo PHP_EOL;
        Brush::paintOnConsole("Please enter a 4-digit number:", ForegroundColors::GREEN);
    }

    private function hostGame()
    {
        if ($this->isTestingEnv()) {
            return;
        }

        $secretNumber = NumberGenerator::generate4DigitNumberWithoutRepetitions();

        $guessResult = '0A0B';

        while (!$this->isGameSet($guessResult)) {
            $guessNumber = readline("> ");

            if ($guessNumber == 'exit') {
                return;
            }

            if ($this->isErrorInput($guessNumber)) {
                $this->displayErrorInputMessage();
                continue;
            }

            $guessResult = $this->getGuessResult($secretNumber, $guessNumber);

            if ($this->isGameSet($guessResult)) {
                $this->displayGameSetInfo();
                return;
            }

            $this->displayColumns();

            if ($this->isGuessRecordsExists()) {
                $this->displayGuessRecords();
            }

            $this->displayGuessRecord($guessNumber, $guessResult);
            $this->saveGuessRecord($guessNumber, $guessResult);
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
     * @param string $guessNumber
     * @param string $guessResult
     */
    private function saveGuessRecord(string $guessNumber, string $guessResult): void
    {
        $this->guessRecords[$guessNumber] = $guessResult;
        $this->guessTimes++;
    }

    /**
     * @return bool
     */
    private function isGuessRecordsExists(): bool
    {
        return count($this->guessRecords) > 0;
    }

    private function displayGuessRecords(): void
    {
        foreach ($this->guessRecords as $guessNumberRecord => $guessResultRecord) {
            $this->displayGuessRecord($guessNumberRecord, $guessResultRecord);
        }
    }

    /**
     * @param string $guessResult
     * @return bool
     */
    private function isGameSet(string $guessResult): bool
    {
        return $guessResult == '4A0B';
    }

    private function displayGameSetInfo(): void
    {
        Brush::paintOnConsole("You win! (guess times: $this->guessTimes)", ForegroundColors::BROWN);
    }

    /**
     * @param string $secretNumber
     * @param string $guessNumber
     * @return string
     */
    private function getGuessResult(string $secretNumber, string $guessNumber): string
    {
        $digitChecker = new DigitChecker($secretNumber, $guessNumber);

        return $digitChecker->getResult();
    }

    private function displayColumns(): void
    {
        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor("Guess"),
                new WordWithColor("    Result"),
            ]
        );
    }

    /**
     * @param string $guessNumber
     * @param string $guessResult
     */
    private function displayGuessRecord(string $guessNumber, string $guessResult): void
    {
        Brush::paintMultiWordsOnConsole(
            [
                new WordWithColor("$guessNumber", ForegroundColors::CYAN),
                new WordWithColor("     $guessResult", ForegroundColors::LIGHT_RED),
            ]
        );
    }

    private function displayErrorInputMessage(): void
    {
        Brush::paintOnConsole("Please enter a 4-digit number:", ForegroundColors::RED);
    }

    /**
     * @param string $guessNumber
     * @return bool
     */
    private function isErrorInput(string $guessNumber): bool
    {
        return strlen($guessNumber) != 4 || !is_numeric($guessNumber);
    }
}
