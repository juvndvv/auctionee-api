<?php

namespace App\Social\Application\CreateMessage;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Services\MessageSenderService;

class CreateMessageCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly MessageSenderService $messageSenderService
    )
    {}

    public function __invoke()
    {
            $this->messageSenderService->__invoke(new ChatRoom('', ''), '', '');
    }
}
