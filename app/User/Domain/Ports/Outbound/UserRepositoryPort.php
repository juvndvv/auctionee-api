<?php

namespace App\User\Domain\Ports\Outbound;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use App\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserRepositoryPort extends BaseRepositoryPort
{

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
     * @return Model
     * @throws NotFoundException
     */
    public function findByUsername(string $username): User;

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
     */
    public function updateAvatar(string $uuid, string $avatar): void;

    /**
     * Bloquea al usuario. Lanza excepcion si no existe.
     *
     * @param string $uuid
     * @return void
     */
    public function block(string $uuid): void;

    /**
     * Desbloquea al usuario. Lanza excepcion si no existe
     *
     * @param string $uuid
     * @return void
     */
    public function unblock(string $uuid): void;
}
