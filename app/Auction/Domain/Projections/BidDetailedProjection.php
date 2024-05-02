<?php

namespace App\Auction\Domain\Projections;

final class BidDetailedProjection
{
    public function __construct(
        public string $amount,
        public string $username,
        public string $user_avatar,
        public string $date
    )
    {}

    public static function fromPrivimites(array $data): self
    {
        return new self(
            $data['amount'],
            $data['username'],
            $data['user_avatar'],
            $data['date']
        );
    }
}
