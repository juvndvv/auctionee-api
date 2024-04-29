<?php

namespace App\Shared\Infrastructure\Repositories;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Exceptions\TooManyRowsException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Implementación del repositorio base que da funcionalidad a los demas repositorios
 */
abstract class BaseRepository implements BaseRepositoryPort
{
    protected Model $model;
    protected string $entityName;

    protected function setModel(Model $model): void
    {
        $this->model = $model;
    }

    protected function setEntityName(string $entityName): void
    {
        $this->entityName = $entityName;
    }

    public function findAll(int $offset = 0, int $limit = 20): Collection
    {
        $models = $this->model::query()->get()->forPage($offset, $limit);

        if ($models->isEmpty()) {
            throw new NoContentException("No existen entidades $this->entityName");
        }

        return $models;
    }

    public function findOneByPrimaryKeyOrFail(string $primaryKey): mixed
    {
        $model = $this->model::query()->where('uuid', $primaryKey)->get()->first();

        if (is_null($model)) {
            throw new NotFoundException("No se ha encontrado "
                . $this->entityName . " con el id " . $primaryKey);
        }

        return $model;
    }

    public function create(array $data): void
    {
        $this->model::query()->create($data);
    }

    public function updateFieldByPrimaryKey(string $primaryKey, string $field, string $new): void
    {
        $model = self::findOneByPrimaryKeyOrFail($primaryKey);
        $model->update([$field => $new]);
    }

    /**
     * @throws NotFoundException
     */
    public function deleteByPrimaryKey(string $primaryKey): void
    {
        $model = self::findOneByPrimaryKeyOrFail($primaryKey);
        $model->delete();
    }

    /**
     * @throws NotFoundException
     * @throws TooManyRowsException
     */
    public function deleteByFieldValue(string $field, string $value): void
    {
        $model = self::findByFieldValue($field, $value);

        if ($model instanceof Collection) {
            throw new TooManyRowsException("Hay mas de una coincidencia para el valor dado");
        }

        $model->delete();
    }

    public function existsByPrimaryKey(string $primaryKey): bool
    {
        return $this->model::query()->find($primaryKey)->exists();
    }

    public function findByFieldValue(string $field, string $value): Collection
    {
        $builders = $this->model::query()->where($field, '=', $value)->get();

        if ($builders->count() === 0) {
            throw new NotFoundException("No se ha encontrado el " . $field . " con el valor " . $value);
        }

        return $builders;
    }

    public function existsByFieldValue(string $field, string $value): bool
    {
        return $this->model::query()->where($field, $value)->exists();
    }
}
