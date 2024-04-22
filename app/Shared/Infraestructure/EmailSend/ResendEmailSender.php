<?php

namespace App\Shared\Infraestructure\EmailSend;

use App\Shared\Domain\Ports\Outbound\EmailSenderPort;

class ResendEmailSender implements EmailSenderPort
{

    public function sendWelcomeEmail(string $email, string $name, string $avatar): void
    {
        // TODO: Implement sendWelcomeEmail() method.
    }

    public function sendUpdateEmail(string $email, string $name, string $field, string $old, string $new): void
    {
        // TODO: Implement sendUpdateEmail() method.
    }

    public function sendDeleteEmail(string $email, string $name): void
    {
        // TODO: Implement sendDeleteEmail() method.
    }

    public function sendBlockedEmail(string $email, string $name): void
    {
        // TODO: Implement sendBlockedEmail() method.
    }

    public function sendUnblockedEmail(string $email, string $name): void
    {
        // TODO: Implement sendUnblockedEmail() method.
    }
}
