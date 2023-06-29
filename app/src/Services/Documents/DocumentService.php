<?php

namespace App\Services\Documents;

use App\Entity\Document\Document;
use App\Entity\Project\Project;
use App\Repository\Document\DocumentRepository;

class DocumentService
{
    public function __construct(private DocumentRepository $documentRepository)
    {
    }
    public function saveDocument(string $fileName, Project $project): void
    {
        $document = new Document();
        $document->setFile($fileName);
        $document->setProject($project);

        $project->addDocument($document);

        $this->documentRepository->save($document);
    }

}
