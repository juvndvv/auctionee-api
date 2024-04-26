<?php

namespace App\Shared\Infrastucture\Listeners;

use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\User\Domain\Events\UserUnblockedEvent;

final class UserUnblockedListener extends BaseListener
{
    public function handle(UserUnblockedEvent $event): void
    {
        $this->sendDeletedEmail($event);
    }

    public function sendDeletedEmail(UserUnblockedEvent $event): void
    {
        $to = $event->payload['email'];
        $name = $event->payload['name'];

        $command = SendEmailCommand::create($to, $name, Email::UNBLOCKED);
        $this->commandBus->handle($command);
    }
}
