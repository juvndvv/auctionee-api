<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Financial\Application\CreateWallet\CreateWalletCommand;
use App\Retention\Email\Application\SendEmailCommand;
use App\Shared\Infraestructure\Bus\Command\CommandBus;
use App\UserManagement\Domain\Events\UserCreatedEvent;

class UserCreatedListener
{
    public function __construct(
        private readonly CommandBus $commandBus
    )
    {}

    public function handle(UserCreatedEvent $event): void
    {
        $this->sendWelcomeEmail($event);
        $this->createWallet($event);
    }

    public function sendWelcomeEmail(UserCreatedEvent $event): void
    {
        $command = new SendEmailCommand($event->message['email'], $event->message['name'], "welcome");
        $this->commandBus->handle($command);
    }

    public function createWallet(UserCreatedEvent $event): void
    {
        $command = new CreateWalletCommand($event->message['uuid']);
        $this->commandBus->handle($command);
    }
}
