<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Financial\Application\DeleteWallet\DeleteWalletCommand;
use App\UserManagement\Domain\Events\UserDeletedEvent;
use App\UserManagement\Domain\Models\User;

class UserDeletedListener extends BaseListener
{
    public function handle(UserDeletedEvent $event): void
    {
        $this->deleteWallet($event);
    }

    public function deleteWallet(UserDeletedEvent $event): void
    {
        $userUuid = $event->message[User::SERIALIZED_UUID];
        $command = DeleteWalletCommand::create($userUuid);
        $this->commandBus->handle($command);
    }
}
