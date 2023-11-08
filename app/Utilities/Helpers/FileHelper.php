<?php

namespace App\Utilities\Helpers;

use Symfony\Component\Mime\MimeTypes;
use Illuminate\Http\UploadedFile as UploadedFile;

class FileHelper
{

    /**
     * Get extension
     *
     * @param string $mineType The mine type.
     * @return array The extensions of file.
     */
    public static function getExtensionsFromMimeType($mineType)
    {
        $mimeTypes = new MimeTypes();
        return $mimeTypes->getExtensions($mineType);
    }

    /**
     * Make relative
     *
     * @param string $dirName The folder dir name.
     * @return string The relative patch.
     */
    public static function makeRelativePath($dirName)
    {
        return "/" . $dirName . "/";
    }

    /**
     * Get original file name
     *
     * @param UploadedFile $file The uploaded file.
     * @return string The original file name.
     */
    public static function getOriginalFileName(UploadedFile $file)
    {
        setlocale(LC_ALL, 'ja_JP.UTF-8');
        
        return pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    }
}