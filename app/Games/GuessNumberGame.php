<?php

namespace App\Games;

use App\Elements\WordWithColor;
use App\Enums\Colors\ForegroundColors;
use App\Helpers\GuessNumberChecker;
use App\Helpers\InputChecker;
use App\Utilities\Brush;
use App\Helpers\NumberGenerator;

class GuessNumberGame
{
    protected array $options;
    protected bool $isDisplayForHelp;

    protected array $guessRecords = [];
    protected int $guessTimes = 1;
    protected int $length;

    public function __construct(array $options)
    {
        $this->options = $options;

        $this->isDisplayForHelp = isset($options['help']) || isset($options['h']);
        $this->length = $this->resolveLength($options);
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
                new WordWithColor("         Display help for the given command. \n"),
                new WordWithColor("  -l, --length", ForegroundColors::GREEN),
                new WordWithColor("       Setting for the digit number (default: 4)."),
            ],
        );
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

        $numberGenerator = new NumberGenerator($this->length);
        $secretNumber = $numberGenerator->generateDigitNumberWithoutRepetitions();

        $guessResult = '0A0B';

        $inputChecker = new InputChecker($this->length);

        while (!$this->isGameSet($guessResult)) {
            $guessNumber = readline("> ");

            if ($guessNumber == 'exit') {
                return;
            }

            if (!$inputChecker->isValid($guessNumber)) {
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
            $this->writeDownGuessRecord($guessNumber, $guessResult);
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
    private function writeDownGuessRecord(string $guessNumber, string $guessResult): void
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
        $length = $this->length;

        return $guessResult == $length.'A0B';
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
        $guessGameChecker = new GuessNumberChecker($secretNumber, $guessNumber);

        return $guessGameChecker->getResult();
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

        if (isset($options['l'])) {
            return (int) $options['l'];
        }

        return isset($options['length']) ? (int) $options['length'] : $default;
    }
}
