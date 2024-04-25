<?php

namespace App\Review\Application\FindUserAverage;

use App\Shared\Infraestructure\Bus\Query\Query;

class FindUserAverageQuery extends Query
{
    public function __construct(private readonly string $userUuid)
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }
}
