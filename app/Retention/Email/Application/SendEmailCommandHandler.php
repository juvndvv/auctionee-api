<?php

namespace App\Retention\Email\Application;

use App\Retention\Email\Domain\Ports\Outbound\EmailRepositoryPort;
use App\Retention\Email\Domain\Ports\Outbound\EmailSenderPort;
use App\Shared\Domain\Bus\Command\CommandHandler;

class SendEmailCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EmailRepositoryPort $emailRepository,
        private readonly EmailSenderPort $emailSender
    ) {}

    public function __invoke(SendEmailCommand $command): void
    {
        $to = $command->to();
        $name = $command->name();
        $type = $command->type();

        $email = $this->emailRepository->getWelcomeEmail($to, $name);
        $this->emailSender->send($email);
    }
}
