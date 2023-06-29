<?php

namespace App\Controller\Document;

use App\Entity\Document\Document;
use App\Services\Documents\DocumentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/document', name: 'document_')]
class DocumentController extends AbstractController
{
    #[Route('process/{id}', name: 'process', requirements: ['id' => Requirement::DIGITS])]
    public function processDocument(Document $document, DocumentService $documentService): void
    {
        $fileName = $document->getFile();

        $fileContents = $documentService->getDocumentContentsByName($fileName);

        //TODO divide text into sentences via SegmentationService
    }
}
