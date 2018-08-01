<?php

namespace App\Services;

use File;

class FolderService
{
    const FOLDER_PROJECTS = 'projects';

    /**
     * @param  string $hash
     * @return string
     */
    public function create(string $hash) :string
    {
        $path = $this->getFolderPath($hash);

        File::makeDirectory($path);

        return $path;  
    }

    /**
     * @param  string $hash
     * @return string
     */
    public function getFolderPath(string $hash) :string
    {
        return storage_path(self::FOLDER_PROJECTS . '/' . $hash);
    }

    /**
     * @param  string $hash
     * @return string
     */
    public function deleteFolder(string $hash)
    {
        $path = $this->getFolderPath($hash);

        File::deleteDirectory($path);
    }
}
