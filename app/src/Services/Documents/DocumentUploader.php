<?php

namespace App\Services\Documents;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

class DocumentUploader
{
    public function __construct(private string $documentsDirectory)
    {
    }
    public function upload(UploadedFile $document): string
    {
        $originalFilename = pathinfo(
            $document->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        $newFilename = sprintf(
            '%s-%s.%s',
                $originalFilename,
                Uuid::v4(),
                $document->guessExtension()
        );

        $document->move(
            $this->documentsDirectory,
            $newFilename
        );

        return $newFilename;
    }
}
