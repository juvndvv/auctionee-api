<?php

namespace App\User\Domain\Ports\Outbound;

use App\Shared\Domain\Exceptions\BadRequestException;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use App\User\Domain\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryPort extends BaseRepositoryPort
{
    /**
     * Busca todos los usuarios. Respuesta paginada
     *
     * @param int $offset
     * @param int $limit
     * @return Collection<User>
     * @throws NoContentException
     */
    public function findAll(int $offset, int $limit): Collection;

    /**
     * Busca el usuario por uuid. Lanza ModelNotFound si no lo encuentra.
     *
     * @param string $uuid
     * @return User
     * @throws NotFoundException
     */
    public function findByUuid(string $uuid): User;

    /**
     * Busca el usuario por el nombre de usuario. Lanza ModelNotFound si no lo encuentra
     *
     * @param string $username
     * @return User
     * @throws NotFoundException
     */
    public function findByUsername(string $username): User;

    /**
     * Busca el usuario por el email. Lanza NotFoundException si no lo encuentra
     *
     * @param string $email
     * @return User
     * @throws NotFoundException
     */
    public function findByEmail(string $email): User;

    /**
     * Actualiza el nombre del usuario. Lanza excepcion si no existe.
     *
     * @param string $uuid
     * @param string $name
     * @return void
     * @throws NotFoundException
     */
    public function updateName(string $uuid, string $name): void;

    /**
     * Actualiza el username. Lanza excepcion si no existe
     *
     * @param string $uuid
     * @param string $username
     * @return void
     * @throws NotFoundException
     */
    public function updateUsername(string $uuid, string $username): void;

    /**
     * Actualiza la password del usuario. Lanza excepcion si no existe.
     *
     * @param string $uuid
     * @param string $password
     * @return void
     * @throws NotFoundException
     */
    public function updatePassword(string $uuid, string $password): void;

    /**
     * Actualiza el email del usuario. Lanza excepcion si no existe
     *
     * @param string $uuid
     * @param string $email
     * @return void
     * @throws NotFoundException
     */
    public function updateEmail(string $uuid, string $email): void;

    /**
     * Actualiza el avatar del usuario. Lanza excepcion si no existe.
     *
     * @param string $uuid
     * @param string $avatar
     * @return void
     * @throws NotFoundException
     */
    public function updateAvatar(string $uuid, string $avatar): void;

    /**
     * Bloquea al usuario. Lanza excepcion si no existe.
     *
     * @param string $uuid
     * @return void
     * @throws NotFoundException
     */
    public function block(string $uuid): void;

    /**
     * Desbloquea al usuario. Lanza excepcion si no existe
     *
     * @param string $uuid
     * @return void
     * @throws NotFoundException
     */
    public function unblock(string $uuid): void;

    /**
     * Devuelve el token si el email y la contraseña son correctos
     *
     * @param string $email
     * @param string $password
     * @return string
     * @throws BadRequestException
     */
    public function authenticate(string $email, string $password): string;
}
