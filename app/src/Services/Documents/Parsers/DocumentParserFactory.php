<?php

namespace App\Services\Documents\Parsers;

use App\Services\Documents\Parsers\Contracts\DocumentParserInterface;

class DocumentParserFactory
{
    public function __construct(private TxtParser $txtParser)
    {
    }
    public function getByExtension(string $extension): DocumentParserInterface
    {
        return match ($extension) {
            'txt' => $this->txtParser,
            default => throw new \Exception('Unsupported file extension')
        };
    }
}
