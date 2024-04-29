<?php

namespace App\Shared\Infrastructure\Listeners;

use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\User\Domain\Events\UserUnblockedEvent;
use ReflectionException;

final class UserUnblockedListener extends BaseListener
{
    /**
     * @throws ReflectionException
     */
    public function handle(UserUnblockedEvent $event): void
    {
        $this->sendDeletedEmail($event);
    }

    /**
     * @throws ReflectionException
     */
    public function sendDeletedEmail(UserUnblockedEvent $event): void
    {
        $to = $event->payload['email'];
        $name = $event->payload['name'];

        $command = SendEmailCommand::create($to, $name, Email::UNBLOCKED);
        $this->commandBus->handle($command);
    }
}
