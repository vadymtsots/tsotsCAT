<?php

namespace App\Services\Documents;

use App\Entity\Document\Document;
use App\Entity\Project\Project;
use App\Repository\Document\DocumentRepository;
use App\Services\Documents\Parsers\DocumentParserFactory;

class DocumentService
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private DocumentParserFactory $documentParserFactory
    ) {
    }
    public function saveDocument(
        string $fileName,
        Project $project,
        string $sourceLanguage,
        string $targetLanguage
    ): void {
        $document = new Document();
        $document->setFile($fileName);
        $document->setProject($project);
        $document->setSourceLanguage($sourceLanguage);
        $document->setTargetLanguage($targetLanguage);

        $project->addDocument($document);

        $this->documentRepository->save($document);
    }

    public function getDocumentContentsByName(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $documentParser = $this->documentParserFactory->getByExtension($extension);

        return $documentParser->parse($fileName);
    }
}
