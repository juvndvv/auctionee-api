<?php

namespace App\Auction\Domain\Projections;

class BidDetailedProjection
{
    public function __construct(
        public string $amount,
        public string $username,
        public string $user_avatar,
        public string $date
    )
    {}

    public static function create(string $amount, string $username, string $user_avatar, string $date): self
    {
        return new self($amount, $username, $user_avatar, $date);
    }
}
