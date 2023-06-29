<?php

namespace App\Services\Documents;

use App\Entity\Document\Document;
use App\Entity\Project\Project;
use App\Repository\Document\DocumentRepository;
use App\Services\Documents\Parsers\DocumentParserFactory;
use App\Services\FileSystem;
use Symfony\Component\Finder\Finder;

class DocumentService
{
    public function __construct(
        private string $documentsDirectory,
        private DocumentRepository $documentRepository,
        private FileSystem $fileSystem,
        private DocumentParserFactory $documentParserFactory
    ) {
    }
    public function saveDocument(string $fileName, Project $project): void
    {
        $document = new Document();
        $document->setFile($fileName);
        $document->setProject($project);

        $project->addDocument($document);

        $this->documentRepository->save($document);
    }

    public function getDocumentContentsByName(string $fileName): string
    {
        $fileSystem = $this->fileSystem->getDocumentFilesystem();

        $extension = $fileSystem->mimeType($fileName);

        $documentParser = $this->documentParserFactory->getByExtension($extension);

        return $documentParser->parse($fileName);
    }

}
