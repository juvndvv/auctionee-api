<?php

namespace App\Review\Application\FindUserAverage;

class FindUserAverageQuery
{
    public function __construct(private readonly string $userUuid)
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }
}
