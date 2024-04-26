<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\User\Domain\Events\UserBlockedEvent;

final class UserBlockedListener extends BaseListener
{
    public function handle(UserBlockedEvent $event): void
    {
        $this->sendDeletedEmail($event);
    }

    public function sendDeletedEmail(UserBlockedEvent $event): void
    {
        $to = $event->payload['email'];
        $name = $event->payload['name'];

        $command = SendEmailCommand::create($to, $name, Email::BLOCKED);
        $this->commandBus->handle($command);
    }
}
