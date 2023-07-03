<?php

namespace App\Services\Documents\Segmentation;

class SegmentationService
{
    public const DEFAULT_SEPARATOR = '. ';

    public function getSegments(string $text): array
    {
        return explode(self::DEFAULT_SEPARATOR, $text);
    }
}
