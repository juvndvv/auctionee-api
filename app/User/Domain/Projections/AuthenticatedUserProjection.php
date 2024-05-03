<?php

namespace App\User\Domain\Projections;

use App\User\Domain\Models\User;

final readonly class AuthenticatedUserProjection
{
    public function __construct(
        public UserDetailsProjection $user,
        public string                $token,
    )
    {}

    public static function create(User $user, string $token): self
    {
        return new self(UserDetailsProjection::create($user), $token);
    }
}
