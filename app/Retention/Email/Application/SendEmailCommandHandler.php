<?php

namespace App\Retention\Email\Application;

use App\Retention\Email\Domain\Model\Email;
use App\Retention\Email\Domain\Ports\Outbound\EmailRepositoryPort;
use App\Retention\Email\Domain\Ports\Outbound\EmailSenderPort;
use App\Shared\Application\Commands\CommandHandler;

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

        $email = match ($type) {
            Email::WELCOME => $this->emailRepository->getWelcomeEmail($to, $name),
            Email::DELETED => $this->emailRepository->getDeletedUserEmail($to, $name),
            Email::UPDATED => $this->emailRepository->getUpdateEmail($to, $name),
            Email::BLOCKED => $this->emailRepository->getBlockedEmail($to, $name),
            Email::UNBLOCKED => $this->emailRepository->getUnblockedEmail($to, $name),
        };

        $this->emailSender->send($email);
    }
}
