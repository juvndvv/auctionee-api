<?php

namespace App\Retention\Email\Infraestructure\EmailSender;

use App\Retention\Email\Domain\Model\Email;
use App\Retention\Email\Domain\Ports\Outbound\EmailSenderPort;
use Resend\Laravel\Facades\Resend;

class ResendEmailSender implements EmailSenderPort
{
    public function send(Email $email)
    {
        Resend::emails()->send([
           'from' => $email->from(),
           'to' => $email->to(),
           'subject' => $email->subject(),
            'html' => $email->content()
        ]);
    }
}
