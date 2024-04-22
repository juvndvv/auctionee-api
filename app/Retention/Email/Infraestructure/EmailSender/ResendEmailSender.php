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
           'from' => env("MAIL_FROM_ADDRESS"),
           'to' => $email->to(),
           'subject' => 'Bienvenido a ' . env('APP_NAME'),
            'html' => $email->content()
        ]);
    }
}
