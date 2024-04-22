<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Application\SendWelcomeEmail\SendWelcomeEmailCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Events\EventBus;
use App\UserManagement\Domain\Events\UserCreatedEvent;
use App\UserManagement\Domain\Events\UserDeletedEvent;

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
    }

    public function sendWelcomeEmail(UserCreatedEvent $event): void
    {
        // Send welcome email
        $command = new SendEmailCommand($event->message['email'], $event->message['name'], "welcome");
        $this->commandBus->handle($command);
    }
}
