<?php

namespace App\Auction\Domain\Projections;

final class AuctionOverviewProjection
{
    public string $avatar;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $starting_date,
        public string $starting_price,
        string $avatar
    )
    {
        $this->avatar = env("CLOUDFLARE_R2_URL") . $avatar;
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['uuid'],
            $data['name'],
            $data['starting_date'],
            $data['starting_price'],
            $data['avatar'],
        );
    }
}
