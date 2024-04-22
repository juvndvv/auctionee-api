<?php

namespace App\Retention\Email\Infraestructure\Repositories;

use App\Retention\Email\Domain\Model\Email;
use App\Retention\Email\Domain\Ports\Outbound\EmailRepositoryPort;

class InMemoryEmailRepository implements EmailRepositoryPort
{
    public function getWelcomeEmail(string $to, string $name): Email
    {
        $content = "<p>¡Hola $name!</p><p>¡Bienvenido a Auctionee! Estamos encantados de tenerte con nosotros y queremos agradecerte por unirte a nuestra comunidad. Aquí en [Nombre de la página web], estamos comprometidos a proporcionarte una experiencia excepcional y a brindarte todo el apoyo que necesites para aprovechar al máximo nuestro sitio.</p><p>Queremos que te sientas como en casa, así que no dudes en explorar todas las características y servicios que tenemos para ofrecerte. Desde artículos informativos hasta recursos útiles, estamos aquí para ayudarte en tu viaje.</p><p>Además, asegúrate de echar un vistazo a nuestras opciones de membresía premium, donde podrás acceder a contenido exclusivo y disfrutar de beneficios adicionales.</p><p>Si tienes alguna pregunta o necesitas asistencia, nuestro equipo de soporte está disponible para ayudarte en cualquier momento. No dudes en ponerte en contacto con nosotros a través de nuestro correo electrónico de soporte o mediante nuestro chat en vivo.</p><p>¡Gracias por unirte a nosotros y esperamos que tu experiencia en Auctionee sea increíble!</p><p>¡Saludos cordiales,</p><p>Juan Daniel Forner Garriga,</p><p>Equipo de Auctionee</p>";

        return new Email(
            $to,
            $content
        );
    }
}
