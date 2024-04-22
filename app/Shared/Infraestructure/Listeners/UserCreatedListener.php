<?php

namespace App\Shared\Infraestructure\Listeners;

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
        private readonly EventBus $eventBus,
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
        $command = new SendWelcomeEmailCommand($event->message['email'], $event->message['name']);
        $this->commandBus->handle($command);
    }
}
