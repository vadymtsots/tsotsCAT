<?php

namespace App\Services\Segments;

use App\Entity\Document\Document;
use App\Entity\Segment\Segment;
use App\Repository\SegmentRepository;
use App\Services\Elasticsearch\ElasticsearchService;

class SegmentService
{
    public function __construct(
        private SegmentRepository $segmentRepository,
        private ElasticsearchService $elasticsearchService
    ) {
    }

    public function saveSegment(
        Document $document,
        string $sourceText,
        string $sourceLanguage,
        string $targetLanguage,
        ?string $targetText = null
    ): void {
        $segment = new Segment();
        $segment->setDocument($document);
        $segment->setSourceText($sourceText);
        $segment->setSourceLanguage($sourceLanguage);
        $segment->setTargetLanguage($targetLanguage);

        if (null !== $targetText) {
            $segment->setTargetText($targetText);
        }

        $this->segmentRepository->save($segment);
    }

    public function updateSegmentById(int $id, string $targetText): void
    {
        $segment = $this->segmentRepository->find($id);
        $segment->setTargetText($targetText);
        $this->segmentRepository->save($segment);
    }

    public function processSourceTextSegmentByDocument(Document $document, array $sourceTextSegments): void
    {
        foreach ($sourceTextSegments as $sourceTextSegment) {
            $segment = $this->elasticsearchService->searchSegment(
                $sourceTextSegment
            );

            $targetText = $segment?->getTargetText();

            $this->saveSegment(
                $document,
                $sourceTextSegment,
                $document->getSourceLanguage(),
                $document->getTargetLanguage(),
                $targetText
            );
        }
    }
}
