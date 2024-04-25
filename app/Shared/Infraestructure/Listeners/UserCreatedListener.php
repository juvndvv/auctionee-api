<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Financial\Application\CreateWallet\CreateWalletCommand;
use App\Retention\Email\Application\SendEmailCommand;
use App\UserManagement\Domain\Events\UserCreatedEvent;

final class UserCreatedListener extends BaseListener
{
    public function handle(UserCreatedEvent $event): void
    {
        $this->sendWelcomeEmail($event);
        $this->createWallet($event);
    }

    public function sendWelcomeEmail(UserCreatedEvent $event): void
    {
        $command = SendEmailCommand::create($event->message['email'], $event->message['name'], "welcome");
        $this->commandBus->handle($command);
    }

    public function createWallet(UserCreatedEvent $event): void
    {
        $command = new CreateWalletCommand($event->message['uuid']);
        $this->commandBus->handle($command);
    }
}
