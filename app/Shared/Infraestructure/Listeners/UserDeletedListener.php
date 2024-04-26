<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Financial\Application\DeleteWallet\DeleteWalletCommand;
use App\Retention\Email\Application\SendEmailCommand;
use App\Retention\Email\Domain\Model\Email;
use App\User\Domain\Events\UserDeletedEvent;
use App\User\Domain\Models\User;

final class UserDeletedListener extends BaseListener
{
    public function handle(UserDeletedEvent $event): void
    {
        $this->deleteWallet($event);
        $this->sendDeletedEmail($event);
    }

    public function sendDeletedEmail(UserDeletedEvent $event): void
    {
        $to = $event->message['email'];
        $name = $event->message['name'];

        $command = SendEmailCommand::create($to, $name, Email::DELETED);
        $this->commandBus->handle($command);
    }

    public function deleteWallet(UserDeletedEvent $event): void
    {
        $userUuid = $event->message[User::SERIALIZED_UUID];
        $command = DeleteWalletCommand::create($userUuid);
        $this->commandBus->handle($command);
    }
}
