<?php

namespace App\Social\Application\Commands\CreateChatRoom;

use App\Shared\Application\Commands\Command;

final class CreateChatRoomCommand extends Command
{
    private function __construct(
        private readonly string $leftUuid,
        private readonly string $rightUuid,
    )
    {}

    public function leftUuid(): string
    {
        return $this->leftUuid;
    }

    public function rightUuid(): string
    {
        return $this->rightUuid;
    }

    public static function create(string $leftUuid, string $rightUuid): CreateChatRoomCommand
    {
        return new self($leftUuid, $rightUuid);
    }
}
