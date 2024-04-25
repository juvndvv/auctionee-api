<?php

namespace App\Shared\Infraestructure\Repositories;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseRepositoryPort
{
    protected Builder $builder;
    protected string $entityName;

    /**
     * Establece el builder para hacer las queries
     *
     * @param Model $model
     * @return void
     */
    protected function setBuilderFromModel(Model $model): void
    {
        $this->builder = $model::query();
    }

    /**
     * Establece el nombre de la entidad
     *
     * @param string $entityName
     * @return void
     */
    protected function setEntityName(string $entityName): void
    {
        $this->entityName = $entityName;
    }

    public function findAll(int $offset = 0, int $limit = 20): Collection
    {
        $models = $this->builder->get()->forPage($offset, $limit);

        if ($models->isEmpty()) {
            throw new NoContentException("No existen entidades $this->entityName");
        }

        return $models;
    }


    public function findOneByPrimaryKeyOrFail(string $primaryKey): Model
    {
        $model = $this->builder->findOrFail($primaryKey);

        if (is_null($model)) {
            throw new ModelNotFoundException("No se ha encontrado"
                . $this->entityName . " con el id " . $primaryKey);
        }

        return $model;
    }

    public function create(array $data): void
    {
        $this->builder->create($data);
    }

    public function updateFieldByPrimaryKey(string $primaryKey, string $field, string $new): void
    {
        $model = self::findOneByPrimaryKeyOrFail($primaryKey);
        $model->update([$field => $new]);
    }

    public function deleteByPrimaryKey(string $primaryKey): void
    {
        $model = self::findOneByPrimaryKeyOrFail($primaryKey);
        $model->delete();
    }

    public function existsByPrimaryKey(string $primaryKey): bool
    {
        return $this->builder->find($primaryKey)->exists();
    }

    public function findByFieldValue(string $field, string $value): Model|Collection
    {
        $builders = $this->builder->where($field, $value)->get();

        if (is_null($builders)) {
            throw new ModelNotFoundException("No se ha encontrado el " . $field . " con el valor " . $value);
        }

        return $builders;
    }

    public function existsByFieldValue(string $field, string $value): bool
    {
        return $this->builder->where($field, $value)->exists();
    }
}
