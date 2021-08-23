<?php

namespace App\Games;

use App\Elements\WordWithColor;
use App\Enums\Colors\BackgroundColors;
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

        while ($guessResult != '4A0B') {
            /**
             * @todo 檢查input是4個不重複的數字
             */
            $guessNumber = readline("> ");

            $digitChecker = new DigitChecker($secretNumber, $guessNumber);
            $guessResult = $digitChecker->getResult();

            if ($guessResult == '4A0B') {
                Brush::paintOnConsole("You win!!!", ForegroundColors::BROWN);
                return;
            }

            Brush::paintMultiWordsOnConsole(
                [
                    new WordWithColor("Guess"),
                    new WordWithColor("    Result"),
                ]
            );

            if ($this->isGuessRecordsExists()) {
                $this->displayGuessRecords();
            }

            Brush::paintMultiWordsOnConsole(
                [
                    new WordWithColor("$guessNumber", ForegroundColors::LIGHT_GREEN),
                    new WordWithColor("     $guessResult", ForegroundColors::LIGHT_CYAN),
                ]
            );

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
     * @param int $guessNumber
     * @param string $guessResult
     */
    private function saveGuessRecord(int $guessNumber, string $guessResult): void
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
            Brush::paintMultiWordsOnConsole(
                [
                    new WordWithColor("$guessNumberRecord", ForegroundColors::LIGHT_GREEN),
                    new WordWithColor("     $guessResultRecord", ForegroundColors::LIGHT_CYAN),
                ]
            );
        }
    }
}
