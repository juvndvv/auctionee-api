<?php

namespace App\Retention\Email\Infrastructure\Repositories;

use App\Retention\Email\Domain\Model\Email;
use App\Retention\Email\Domain\Ports\Outbound\EmailRepositoryPort;

class InMemoryEmailRepository implements EmailRepositoryPort
{
    public function getWelcomeEmail(string $to, string $name): Email
    {
        $from = 'Equipo de Auctionee <onboarding@jotade.dev>';

        $subject = "Bienvenido a Auctionee";

        $content = "<p>¡Hola $name!</p><p>¡Bienvenido a Auctionee! Estamos encantados de tenerte con nosotros y queremos agradecerte por unirte a nuestra comunidad. Aquí en Auctionee, estamos comprometidos a proporcionarte una experiencia excepcional y a brindarte todo el apoyo que necesites para aprovechar al máximo nuestro sitio.</p><p>Queremos que te sientas como en casa, así que no dudes en explorar todas las características y servicios que tenemos para ofrecerte. Desde artículos informativos hasta recursos útiles, estamos aquí para ayudarte en tu viaje.</p><p>Además, asegúrate de echar un vistazo a nuestras opciones de membresía premium, donde podrás acceder a contenido exclusivo y disfrutar de beneficios adicionales.</p><p>Si tienes alguna pregunta o necesitas asistencia, nuestro equipo de soporte está disponible para ayudarte en cualquier momento. No dudes en ponerte en contacto con nosotros a través de nuestro correo electrónico de soporte o mediante nuestro chat en vivo.</p><p>¡Gracias por unirte a nosotros y esperamos que tu experiencia en Auctionee sea increíble!</p><p>¡Saludos cordiales,</p><p>Juan Daniel Forner Garriga,</p><p>Equipo de Auctionee</p>";

        return new Email(
            $from,
            $to,
            $content,
            $subject
        );
    }

    public function getUpdateEmail(string $to, string $name): Email
    {
        $from = 'Equipo de Auctionee <soporte@jotade.dev>';

        $subject = "Actualización en tu información";

        $content = "<p>¡Hola $name!</p><p>Queríamos informarte de que se ha realizado un cambio en tu configuración en Auctionee. Hemos actualizado ciertos ajustes para mejorar tu experiencia y asegurarnos de que todo funcione correctamente.</p><p>Por favor, revisa tus configuraciones para asegurarte de que se ajustan a tus preferencias actuales. Si tienes alguna pregunta o necesitas ayuda con estos cambios, no dudes en ponerte en contacto con nuestro equipo de soporte. Estamos aquí para ayudarte en cualquier momento.</p><p>¡Gracias por confiar en Auctionee!</p><p>¡Saludos cordiales,</p><p>Juan Daniel Forner Garriga,</p><p>Equipo de Auctionee</p>";

        return new Email(
            $from,
            $to,
            $content,
            $subject
        );
    }

    public function getBlockedEmail(string $to, string $name): Email
    {
        $from = 'Equipo de Auctionee <soporte@jotade.dev>';

        $subject = "Cuenta bloqueada";

        $content = "<p>¡Hola $name!</p><p>Lamentamos informarte que tu cuenta en Auctionee ha sido bloqueada temporalmente. Esto puede haber ocurrido debido a violaciones de nuestras políticas o términos de uso.</p><p>Por favor, ponte en contacto con nuestro equipo de soporte para obtener más información sobre el motivo del bloqueo y para discutir los próximos pasos. Estamos aquí para ayudarte y resolver cualquier problema que pueda haber causado esta situación.</p><p>Esperamos poder resolver este problema contigo y que pronto puedas volver a disfrutar de todos los servicios de Auctionee.</p><p>¡Gracias por tu comprensión!</p><p>¡Saludos cordiales,</p><p>Juan Daniel Forner Garriga,</p><p>Equipo de Auctionee</p>";

        return new Email(
            $from,
            $to,
            $content,
            $subject
        );
    }

    public function getUnblockedEmail(string $to, string $name): Email
    {
        $from = 'Equipo de Auctionee <soporte@jotade.dev>';

        $subject = "Cuenta desbloqueada";

        $content = "<p>¡Hola $name!</p><p>Nos complace informarte que tu cuenta en Auctionee ha sido desbloqueada con éxito. Hemos revisado la situación y hemos tomado las medidas necesarias para restablecer tu acceso a nuestra plataforma.</p><p>Te pedimos disculpas por cualquier inconveniente que este bloqueo temporal haya podido causarte y te agradecemos por tu paciencia y comprensión durante este proceso.</p><p>Si tienes alguna pregunta o necesitas asistencia adicional, no dudes en ponerte en contacto con nuestro equipo de soporte. Estamos aquí para ayudarte en todo lo que necesites.</p><p>¡Esperamos verte pronto de nuevo en Auctionee!</p><p>¡Saludos cordiales,</p><p>Juan Daniel Forner Garriga,</p><p>Equipo de Auctionee</p>";

        return new Email(
            $from,
            $to,
            $content,
            $subject
        );
    }

    public function getDeletedUserEmail(string $to, string $name): Email
    {
        $from = 'Equipo de Auctionee <soporte@jotade.dev>';

        $subject = "Cuenta eliminada";

        $content = "<p>¡Hola $name!</p><p>Lamentamos informarte que tu cuenta en Auctionee ha sido eliminada. Hemos recibido una solicitud de eliminación de cuenta por tu parte o hemos tomado esta medida debido a violaciones graves de nuestras políticas o términos de uso.</p><p>Si crees que esto ha sido un error o deseas discutir esta decisión, por favor contáctanos lo antes posible para que podamos revisar tu situación. Estamos aquí para ayudarte y resolver cualquier problema que puedas tener.</p><p>Te agradecemos por haber sido parte de nuestra comunidad y te deseamos lo mejor en tus futuros proyectos.</p><p>¡Saludos cordiales,</p><p>Juan Daniel Forner Garriga,</p><p>Equipo de Auctionee</p>";

        return new Email(
            $from,
            $to,
            $content,
            $subject
        );
    }
}
