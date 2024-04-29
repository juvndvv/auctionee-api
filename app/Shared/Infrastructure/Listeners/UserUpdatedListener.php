<?php

namespace App\Shared\Infrastructure\Listeners;

use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\User\Domain\Events\UserUpdatedEvent;
use ReflectionException;

final class UserUpdatedListener extends BaseListener
{
    /**
     * @throws ReflectionException
     */
    public function handle(UserUpdatedEvent $event): void
    {
        $this->sendUpdatedEmail($event);
    }

    /**
     * @throws ReflectionException
     */
    private function sendUpdatedEmail(UserUpdatedEvent $event): void
    {
        $to = $event->payload['user']['email'];
        $name = $event->payload['user']['name'];

        $command = SendEmailCommand::create($to, $name, Email::UPDATED);
        $this->commandBus->handle($command);
    }
}
