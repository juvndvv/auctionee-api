<?php

namespace App\Review\Application\Query\FindUserAverage;


use App\Shared\Application\Queries\Query;

final class FindUserAverageQuery extends Query
{
    public function __construct(private readonly string $userUuid)
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }
}
