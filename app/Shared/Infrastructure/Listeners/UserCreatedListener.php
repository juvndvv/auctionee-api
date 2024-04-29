<?php

namespace App\Shared\Infrastructure\Listeners;

use App\Financial\Application\Command\CreateWallet\CreateWalletCommand;
use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\User\Domain\Events\UserCreatedEvent;
use ReflectionException;

final class UserCreatedListener extends BaseListener
{
    /**
     * @throws ReflectionException
     */
    public function handle(UserCreatedEvent $event): void
    {
        $this->sendWelcomeEmail($event);
        $this->createWallet($event);
    }

    /**
     * @throws ReflectionException
     */
    private function sendWelcomeEmail(UserCreatedEvent $event): void
    {
        $to = $event->payload['email'];
        $name = $event->payload['name'];

        $command = SendEmailCommand::create($to, $name, Email::WELCOME);
        $this->commandBus->handle($command);
    }

    /**
     * @throws ReflectionException
     */
    private function createWallet(UserCreatedEvent $event): void
    {
        $uuid = $event->payload['uuid'];

        $command = new CreateWalletCommand($uuid);
        $this->commandBus->handle($command);
    }
}
