<?php

namespace App\Shared\Domain\Ports\Outbound;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Exceptions\NotFoundException;
use Illuminate\Support\Collection;

/**
 * Interfaz del repositorio base que da funcionalidades generales a los demas repositorios
 */
interface BaseRepositoryPort
{
    /**
     * Busca y devuelve una Coleccion de modelos. Lanza excepcion si no encuentra
     *
     * @param int $offset
     * @param int $limit
     * @return Collection
     * @throws NoContentException
     */
    public function findAll(int $offset = 0, int $limit = 20): Collection;

    /**
     * Busca un modelo por su clave primaria y devuelve su modelo de dominio. Lanza excepcion si no encuentra
     *
     * @param string $primaryKey
     * @return mixed
     * @throws NotFoundException
     */
    public function findOneByPrimaryKeyOrFail(string $primaryKey): mixed;

    /**
     * Busca y devuelve modelos por el valor <i>value</i> de un campo <i>field</i>. Lanza ModelNotFound si.
     * no lo encuentra. Devuelve una instancia del modelo del dominio
     *
     * @param string $field
     * @param string $value
     * @return mixed
     * @throws NotFoundException
     */
    public function findByFieldValue(string $field, string $value): mixed;

    /**
     * Registra el modelo en la base de datos
     *
     * @param array $data
     * @return void
     */
    public function create(array $data): void;

    /**
     * Actualiza el campo <i>field</i> de la base de datos del modelo identificado con <i>uuid</i>
     * al valor <i>new</i>
     *
     * @param string $primaryKey
     * @param string $field
     * @param string $new
     * @return void
     * @throws NotFoundException
     */
    public function updateFieldByPrimaryKey(string $primaryKey, string $field, string $new): void;

    /**
     * Elimina el modelo por su clave primaria
     *
     * @param string $primaryKey
     * @return void
     */
    public function deleteByPrimaryKey(string $primaryKey): void;

    /**
     * Elimina el modelo por el valor <i>value</i> de un campo <i>field</i>
     *
     * @param string $field
     * @param string $value
     * @return void
     */
    public function deleteByFieldValue(string $field, string $value): void;

    /**
     * <p>Comprueba si existe un modelo por su clave primaria</p>
     *
     * @param string $primaryKey
     * @return bool
     */
    public function existsByPrimaryKey(string $primaryKey): bool;

    /**
     * <p>Comprueba si existe un modelo por el valor <i>value</i> de un campo <i>field</i>. Lanza
     * ModelNotFound si no lo encuentra</p>
     *
     * @param string $field
     * @param string $value
     * @return bool
     */
    public function existsByFieldValue(string $field, string $value): bool;
}
