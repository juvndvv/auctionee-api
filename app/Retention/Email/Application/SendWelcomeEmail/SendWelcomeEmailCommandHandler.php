<?php

namespace App\Retention\Email\Application\SendWelcomeEmail;

use App\Retention\Email\Domain\Ports\Outbound\EmailRepositoryPort;
use App\Retention\Email\Domain\Ports\Outbound\EmailSenderPort;
use App\Shared\Domain\Bus\Command\CommandHandler;

class SendWelcomeEmailCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EmailRepositoryPort $emailRepository,
        private readonly EmailSenderPort $emailSender)
    {}

    public function __invoke(SendWelcomeEmailCommand $command): void
    {
        $to = $command->to();
        $name = $command->name();

        $email = $this->emailRepository->getWelcomeEmail($to, $name);
        $this->emailSender->send($email);
    }
}
