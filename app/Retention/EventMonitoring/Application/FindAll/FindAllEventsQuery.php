<?php

namespace App\Retention\EventMonitoring\Application\FindAll;

use App\Shared\Application\Queries\Query;

class FindAllEventsQuery extends Query
{
    private function __construct(
        private readonly int $offset,
        private readonly int $limit
    )
    {}

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public static function create(int $offset, int $limit): FindAllEventsQuery
    {
        return new self($offset, $limit);
    }
}
