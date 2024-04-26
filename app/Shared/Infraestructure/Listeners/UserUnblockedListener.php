<?php

namespace App\Shared\Infraestructure\Listeners;

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
        $to = $event->message['email'];
        $name = $event->message['name'];

        $command = SendEmailCommand::create($to, $name, Email::UNBLOCKED);
        $this->commandBus->handle($command);
    }
}
