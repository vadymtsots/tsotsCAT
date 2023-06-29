<?php

namespace App\Services\Documents\Parsers\Contracts;

interface DocumentParserInterface
{
    public function parse(string $fileName): string;
}
