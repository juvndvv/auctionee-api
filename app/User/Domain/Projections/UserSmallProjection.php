<?php

namespace App\User\Domain\Projections;

use App\User\Domain\Models\User;

final readonly class UserSmallProjection
{
    private function __construct(
        public string $name,
        public string $username,
        public string $avatar,
        public string $role
    )
    {}

    public static function create(User $user): self
    {
        return new self(
            $user->name(),
            $user->username(),
            env("CLOUDFLARE_R2_URL") . $user->avatar(),
            $user->role()
        );
    }
}
