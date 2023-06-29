<?php

namespace App\Services;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem as LeagueFilesystem;

class FileSystem
{
    public function __construct(private string $documentsDirectory)
    {
    }

    public function getDocumentFilesystem(): LeagueFilesystem
    {
        $adapter = new LocalFilesystemAdapter($this->documentsDirectory);
        return new LeagueFilesystem($adapter);
    }
}
