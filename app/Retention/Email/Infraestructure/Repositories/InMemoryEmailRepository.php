<?php

namespace App\Retention\Email\Infraestructure\Repositories;

use App\Retention\Email\Domain\Model\Email;
use App\Retention\Email\Domain\Ports\Outbound\EmailRepositoryPort;

class InMemoryEmailRepository implements EmailRepositoryPort
{
    public function getWelcomeEmail(string $to): Email
    {
        $content = "Bienvenido a auctionee";

        return new Email(
            $to,
            $content
        );
    }
}
