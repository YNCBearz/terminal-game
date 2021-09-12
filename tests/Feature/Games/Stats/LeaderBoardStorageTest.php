<?php

namespace Tests\Feature\Games\Stats;

use App\Games\Processes\GuessRecordBoard;
use App\Games\Stats\LeaderBoardStorage;
use PHPUnit\Framework\TestCase;
use Tests\Feature\Traits\TestStorageTraits;

class LeaderBoardStorageTest extends TestCase
{
    use TestStorageTraits;

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
    public function GivenNoInput_WhenWantToSave_ThenReturnFalse()
    {
        $input = 'N';

        $dummyGuessRecordRecord = $this->createStub(GuessRecordBoard::class);
        $this->sut = new LeaderBoardStorage($dummyGuessRecordRecord);

        $actual = $this->sut->wantToSave($input);

        $this->assertFalse($actual);
    }

//    /**
//     * @test
//     */
//    public function GivenNoFile_WhenSave_ThenCreateNewFile()
//    {
//        $dummyGuessRecordRecord = $this->createStub(GuessRecordBoard::class);
//        $this->sut = new LeaderBoardStorage($dummyGuessRecordRecord);
//
//        $this->sut->save();
//
//        $storagePath = getenv('STORAGE_PATH');
//        $this->assertTrue(file_exists("$storagePath/leaderboard.json"));
//    }

//    /**
//     * @test
//     */
//    public function GivenExistFile_WhenSave_ThenUpdateFile()
//    {
//        $fileName = 'leaderboard.txt';
//        $this->createFileInTestStorage($fileName);
//
//        $dummyGuessRecordRecord = $this->createStub(GuessRecordBoard::class);
//        $this->sut = new LeaderBoardStorage($dummyGuessRecordRecord);
//
//        $this->sut->save();
//
//        $storagePath = getenv('STORAGE_PATH');
//        $this->assertJsonFileEqualsJsonFile();
//    }
}