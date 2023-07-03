<?php

namespace App\Services\Segments;

use App\Entity\Document\Document;
use App\Entity\Segment;
use App\Repository\SegmentRepository;

class SegmentService
{
    public function __construct(private SegmentRepository $segmentRepository)
    {
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
}
