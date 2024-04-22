<?php

namespace App\Retention\Email\Domain\Ports\Outbound;

use App\Retention\Email\Domain\Model\Email;

interface EmailRepositoryPort
{
    public function getWelcomeEmail(string $to): Email;
}
