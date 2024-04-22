<?php

namespace App\Shared\Domain\Ports\Outbound;

interface EmailSenderPort
{
    public function sendWelcomeEmail(string $email, string $name, string $avatar): void;

    public function sendUpdateEmail(string $email, string $name, string $field, string $old, string $new): void;

    public function sendDeleteEmail(string $email, string $name): void;

    public function sendBlockedEmail(string $email, string $name): void;

    public function sendUnblockedEmail(string $email, string $name): void;
}
