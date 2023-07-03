<?php

namespace App\Controller\Document;

use App\Entity\Document\Document;
use App\Services\Documents\DocumentService;
use App\Services\Documents\Segmentation\SegmentationService;
use App\Services\Segments\SegmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/document', name: 'document_')]
class DocumentController extends AbstractController
{
    #[Route('/process/{id}', name: 'process', requirements: ['id' => Requirement::DIGITS])]
    public function processDocument(
        Document $document,
        DocumentService $documentService,
        SegmentationService $segmentationService,
        SegmentService $segmentService
    ): RedirectResponse {
        $fileName = $document->getFile();
        $fileContents = $documentService->getDocumentContentsByName($fileName);

        $textSegments = $segmentationService->getSegments($fileContents);

        foreach ($textSegments as $segment) {
            $segmentService->saveSegment(
                $document,
                $segment,
                $document->getSourceLanguage(),
                $document->getTargetLanguage()
            );
        }

        return $this->redirectToRoute('project_view', ['id' => $document->getProject()->getId()]);
    }
}
