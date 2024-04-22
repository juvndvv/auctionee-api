<?php

namespace App\Shared\Domain\EmailTemplates;

class WelcomeTemplate
{
    public static function generate($email, $name, $avatar)
    {
        return '
            <img src="{$avatar}" alt="{$name}" >
            <h1>Bienvenido a Auctionee {$name}!</h1>
            <p>Hola</p>
        ';
    }
}
