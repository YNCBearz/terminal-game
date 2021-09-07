<?php

namespace Tests\Feature\Games\Stats;

use App\Games\Processes\GuessRecordBoard;
use App\Games\Stats\LeaderBoardStorage;
use PHPUnit\Framework\TestCase;

class LeaderBoardStorageTest extends TestCase
{
    protected LeaderBoardStorage $sut;

    protected function tearDown(): void
    {
        $this->deleteFilesInTestStorages();
    }

    /**
     * @test
     *
     * @dataProvider inputYes
     */
    public function GivenYesInput_WhenWantToSave_ThenReturnTrue($input)
    {
        $dummyGuessRecordRecord = $this->createStub(GuessRecordBoard::class);
        $this->sut = new LeaderBoardStorage($dummyGuessRecordRecord);

        $actual = $this->sut->wantToSave($input);

        $this->assertTrue($actual, "Failed when input: $input");
    }

    public function inputYes(): array
    {
        return [
            ['Y'],
            ['Yes'],
            ['y'],
            ['yes'],
        ];
    }

    /**
     * @test
     */
    public function GivenNoFile_WhenSave_ThenCreateNewFile()
    {
        $dummyGuessRecordRecord = $this->createStub(GuessRecordBoard::class);
        $this->sut = new LeaderBoardStorage($dummyGuessRecordRecord);

        $this->sut->save();

        $storagePath = getenv('STORAGE_PATH');
        $this->assertTrue(file_exists("$storagePath/leaderboard.txt"));
    }

    private function deleteFilesInTestStorages()
    {
        $storagePath = getenv('STORAGE_PATH');

        $files = glob("$storagePath/*");

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

}