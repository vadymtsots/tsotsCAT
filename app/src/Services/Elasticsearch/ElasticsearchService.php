<?php

namespace App\Services\Elasticsearch;

use App\Entity\Segment\Segment;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchQuery;
use FOS\ElasticaBundle\Finder\FinderInterface;

class ElasticsearchService
{
    public function __construct(private FinderInterface $finder)
    {
    }

    public function searchSegment(string $search): ?Segment
    {
        $boolQuery = new BoolQuery();

        $query = new MatchQuery();
        $query->setFieldQuery('sourceText', $search);
        $query->setFieldParam('sourceText', 'analyzer', 'my_analyzer');

        $boolQuery->addShould($query);

        /** @var array<Segment> $segments */
        $segments = $this->finder->find($boolQuery);

        return $segments[0] ?? null;
    }
}
