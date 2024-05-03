<?php

namespace App\User\Domain\Projections;

use App\User\Domain\Models\User;

final readonly class UserDetailsProjection
{
    private function __construct(
        public string $uuid,
        public string $name,
        public string $username,
        public string $email,
        public string $avatar,
        public string $birth,
        public string $role,
    )
    {}

    public static function create(User $user): self
    {
        return new self(
            $user->id(),
            $user->name(),
            $user->username(),
            $user->email(),
            env("CLOUDFLARE_R2_URL") . $user->avatar(),
            $user->birth(),
            $user->role()
        );
    }
}
