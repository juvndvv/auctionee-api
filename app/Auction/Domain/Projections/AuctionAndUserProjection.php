<?php

namespace App\Auction\Domain\Projections;

final class AuctionAndUserProjection
{
    public string $avatar;
    public string $user_avatar;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $description,
        public float    $price,
        public string $date,
        public int $duration,
        string $avatar,
        public string $user_uuid,
        public string $user_username,
        string $user_avatar,
        public string $category_uuid,
        public string $category_name,
        public string $category_avatar,
    )
    {
        $this->avatar = env("CLOUDFLARE_R2_URL") . $avatar;
        $this->user_avatar = env("CLOUDFLARE_R2_URL") . $user_avatar;
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['uuid'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['date'],
            $data['duration'],
            $data['avatar'],
            $data['user_uuid'],
            $data['user_username'],
            $data['user_avatar'],
            $data['category_uuid'],
            $data['category_name'],
            $data['category_avatar']
        );
    }
}
