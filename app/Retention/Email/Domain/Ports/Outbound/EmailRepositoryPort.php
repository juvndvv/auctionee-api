<?php

namespace App\Retention\Email\Domain\Ports\Outbound;

use App\Retention\Email\Domain\Model\Email;

interface EmailRepositoryPort
{
    public function getWelcomeEmail(string $to, string $name): Email;
    public function getUpdateEmail(string $to, string $name): Email;
    public function getBlockedEmail(string $to, string $name): Email;
    public function getUnblockedEmail(string $to, string $name): Email;
    public function getDeletedUserEmail(string $to, string $name): Email;
}
