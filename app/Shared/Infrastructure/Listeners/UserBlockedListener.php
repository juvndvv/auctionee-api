<?php

namespace App\Shared\Infrastructure\Listeners;

use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\User\Domain\Events\UserBlockedEvent;
use ReflectionException;

final class UserBlockedListener extends BaseListener
{
    /**
     * @throws ReflectionException
     */
    public function handle(UserBlockedEvent $event): void
    {
        $this->sendDeletedEmail($event);
    }

    /**
     * @throws ReflectionException
     */
    public function sendDeletedEmail(UserBlockedEvent $event): void
    {
        $to = $event->payload['email'];
        $name = $event->payload['name'];

        $command = SendEmailCommand::create($to, $name, Email::BLOCKED);
        $this->commandBus->handle($command);
    }
}
