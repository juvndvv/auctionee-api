<?php

namespace App\User\Domain\Resources;

use App\User\Domain\Models\User;

final readonly class AuthenticatedUser
{
    public function __construct(
        public UserDetailsResource $user,
        public string $token,
    )
    {}

    public static function create(User $user, string $token): self
    {
        return new self(UserDetailsResource::create($user), $token);
    }
}
