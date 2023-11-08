<?php

namespace App\Utilities\Helpers;

class FolderHelper
{
    /**
     * Create folder if not existed
     *
     * @param string $type
     * @return void
     */
    public static function new(string $type)
    {
        $directoryPath = public_path(FileHelper::makeRelativePath($type));

        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }
    }
}