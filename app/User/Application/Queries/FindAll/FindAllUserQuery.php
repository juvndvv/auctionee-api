<?php

namespace App\User\Application\Queries\FindAll;

use App\Shared\Application\Queries\Query;

final class FindAllUserQuery extends Query
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
}
