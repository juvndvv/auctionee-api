<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\UserManagement\Domain\Events\UserUpdatedEvent;

class UserUpdatedListener extends BaseListener
{
    public function handle(UserUpdatedEvent $event): void
    {
        $this->sendUpdatedEmail($event);
    }

    private function sendUpdatedEmail(UserUpdatedEvent $event): void
    {
        $to = $event->message['user']['email'];
        $name = $event->message['user']['name'];

        $command = SendEmailCommand::create($to, $name, Email::UPDATED);
        $this->commandBus->handle($command);
    }
}
