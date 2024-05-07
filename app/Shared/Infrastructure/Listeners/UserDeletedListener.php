<?php

namespace App\Shared\Infrastructure\Listeners;

use App\Financial\Application\Command\DeleteWallet\DeleteWalletCommand;
use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\User\Domain\Events\UserDeletedEvent;
use App\User\Domain\Models\User;
use ReflectionException;

final class UserDeletedListener extends BaseListener
{
    /**
     * @throws ReflectionException
     */
    public function handle(UserDeletedEvent $event): void
    {
        $this->deleteWallet($event);
        $this->sendDeletedEmail($event);
    }

    /**
     * @throws ReflectionException
     */
    public function sendDeletedEmail(UserDeletedEvent $event): void
    {
        $to = $event->payload['email'];
        $name = $event->payload['name'];

        $command = SendEmailCommand::create($to, $name, Email::DELETED);
        $this->commandBus->handle($command);
    }

    /**
     * @throws ReflectionException
     */
    public function deleteWallet(UserDeletedEvent $event): void
    {
        $userUuid = $event->payload[User::UUID];
        $command = DeleteWalletCommand::create($userUuid);
        $this->commandBus->handle($command);
    }
}
