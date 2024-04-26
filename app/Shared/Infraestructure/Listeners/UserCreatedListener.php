<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Financial\Application\CreateWallet\CreateWalletCommand;
use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\User\Domain\Events\UserCreatedEvent;

final class UserCreatedListener extends BaseListener
{
    public function handle(UserCreatedEvent $event): void
    {
        $this->sendWelcomeEmail($event);
        $this->createWallet($event);
    }

    private function sendWelcomeEmail(UserCreatedEvent $event): void
    {
        $to = $event->payload['email'];
        $name = $event->payload['name'];

        $command = SendEmailCommand::create($to, $name, Email::WELCOME);
        $this->commandBus->handle($command);
    }

    private function createWallet(UserCreatedEvent $event): void
    {
        $uuid = $event->payload['uuid'];

        $command = new CreateWalletCommand($uuid);
        $this->commandBus->handle($command);
    }
}
