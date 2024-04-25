<?php

namespace App\Shared\Domain\Ports\Outbound;

use App\Shared\Domain\Exceptions\NoContentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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
     * Busca un modelo por su clave primaria. Lanza excepcion si no encuentra
     *
     * @param string $primaryKey
     * @return Model
     */
    public function findOneByPrimaryKeyOrFail(string $primaryKey): Model;

    /**
     * Busca y devuelve modelos por el valor <i>value</i> de un campo <i>field</i>. Lanza ModelNotFound si
     * no lo encuentra
     *
     * @param string $field
     * @param string $value
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findByFieldValue(string $field, string $value): Model|Collection;

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
     * @throws ModelNotFoundException
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
     * Comprueba si existe un modelo por su clave primaria
     *
     * @param string $primaryKey
     * @return bool
     */
    public function existsByPrimaryKey(string $primaryKey): bool;

    /**
     * Comprueba si existe un modelo por el valor <i>value</i> de un campo <i>field</i>. Lanza
     * ModelNotFound si no lo encuentra
     */
    public function existsByFieldValue(string $field, string $value): bool;
}
