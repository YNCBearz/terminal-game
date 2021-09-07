<?php

namespace Tests\Feature\Traits;

trait TestStorageTraits
{
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

    /**
     * @param string $fileName
     */
    private function createFileInTestStorage(string $fileName)
    {
        $storagePath = getenv('STORAGE_PATH');
        $file = fopen("$storagePath/$fileName", "a+");

        $text = 'Create By Test';
        fwrite($file, $text);
        fclose($file);
    }
}