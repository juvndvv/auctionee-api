<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Retention\Email\Application\SendEmailCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\UserManagement\Domain\Events\UserCreatedEvent;

class UserCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly CommandBus $commandBus
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreatedEvent $event): void
    {
        $this->sendWelcomeEmail($event);
        // TODO crear wallet para el usuario
    }

    public function sendWelcomeEmail(UserCreatedEvent $event): void
    {
        $command = new SendEmailCommand($event->message['email'], $event->message['name'], "welcome");
        $this->commandBus->handle($command);
    }
}
