<?php

namespace App\Services\Documents\Parsers;

use App\Services\Documents\Parsers\Contracts\DocumentParserInterface;
use App\Services\FileSystem;

class TxtParser implements DocumentParserInterface
{
    public function __construct(private FileSystem $fileSystem)
    {
    }

    public function parse(string $fileName): string
    {
        $fileSystem = $this->fileSystem->getDocumentFilesystem();

        return $fileSystem->read($fileName);
    }
}
