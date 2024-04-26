<?php

namespace App\Financial\Application\DeleteWallet;

use App\Shared\Application\Commands\Command;

class DeleteWalletCommand extends Command
{
    public function __construct(
        private readonly string $userUuid,
    )
    {}

    public static function create(string $userUuid): self
    {
        return new self($userUuid);
    }

    public function userUuid(): string
    {
        return $this->userUuid;
    }
}
