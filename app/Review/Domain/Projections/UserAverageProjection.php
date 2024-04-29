<?php

namespace App\Review\Domain\Projections;

final class UserAverageProjection
{
    public function __construct(
        public float $average,
    )
    {}

    public static function create(float $average): self
    {
        return new self($average);
    }
}
