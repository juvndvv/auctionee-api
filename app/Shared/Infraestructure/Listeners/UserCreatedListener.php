<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\EventMonitoring\Application\Place\PlaceEventCommand;
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
        $this->persist($event);
    }

    public function sendWelcomeEmail(UserCreatedEvent $event): void
    {
        // Send welcome email
        $command = new SendEmailCommand($event->message['email'], $event->message['name'], "welcome");
        $this->commandBus->handle($command);
    }

    public function persist($event): void
    {
        $command = new PlaceEventCommand($event->eventId, $event->eventType, json_encode($event->message), date('Y-m-d H:i:s', strtotime($event->ocurredOn)));
        $this->commandBus->handle($command);
    }
}
