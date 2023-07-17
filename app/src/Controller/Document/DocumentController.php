<?php

namespace App\Controller\Document;

use App\Entity\Document\Document;
use App\Services\Documents\DocumentService;
use App\Services\Documents\Segmentation\SegmentationService;
use App\Services\Segments\SegmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        if ($document->getSegments()->count() > 0) {
            return $this->redirectToRoute('document_index', ['id' => $document->getId()]);
        }

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

        return $this->redirectToRoute('document_index', ['id' => $document->getId()]);
    }

    #[Route('/save-translation', name: 'save_translation')]
    public function saveTranslations(Request $request)
    {
        dd($request->getContent());
    }

    #[Route('/{id}', name: 'index')]
    public function index(Document $document): Response
    {
        $segments = $document->getSegments();

        return $this->render('document/index.html.twig', [
            'documentId' => $document->getId(),
            'segments' => $segments,
        ]);
    }
}
