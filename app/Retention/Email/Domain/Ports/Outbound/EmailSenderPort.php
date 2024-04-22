<?php

namespace App\Retention\Email\Domain\Ports\Outbound;

use App\Retention\Email\Domain\Model\Email;

interface EmailSenderPort
{
    public function send(Email $email);
}
