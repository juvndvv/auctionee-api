<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Financial\Application\CreateWallet\CreateWalletCommand;
use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\UserManagement\Domain\Events\UserCreatedEvent;

final class UserCreatedListener extends BaseListener
{
    public function handle(UserCreatedEvent $event): void
    {
        $this->sendWelcomeEmail($event);
        $this->createWallet($event);
    }

    private function sendWelcomeEmail(UserCreatedEvent $event): void
    {
        $to = $event->message['email'];
        $name = $event->message['name'];

        $command = SendEmailCommand::create($to, $name, Email::WELCOME);
        $this->commandBus->handle($command);
    }

    private function createWallet(UserCreatedEvent $event): void
    {
        $uuid = $event->message['uuid'];

        $command = new CreateWalletCommand($uuid);
        $this->commandBus->handle($command);
    }
}
