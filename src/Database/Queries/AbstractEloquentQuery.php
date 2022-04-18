<?php

declare(strict_types=1);

namespace LaraStrict\Database\Queries;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * You must implement abstract public function execute.
 *
 * @template TModel of Model
 */
abstract class AbstractEloquentQuery extends AbstractQuery
{
    /**
     * @return class-string<TModel>
     */
    abstract protected function getModelClass(): string;

    /**
     * @param Scope[] $scopes
     *
     * @return ChunkedModelQueryResult<TModel>
     */
    protected function chunk(array $scopes = []): ChunkedModelQueryResult
    {
        return new ChunkedModelQueryResult($this->getModelClass(), $this->getQuery($scopes));
    }

    /**
     * @param Scope[] $scopes
     *
     * @return Collection<int, Model>
     */
    protected function getAll(array $scopes = []): Collection
    {
        return $this->getQuery($scopes)
            ->get();
    }

    /**
     * @param Scope[] $scopes
     */
    protected function get(array $scopes = []): ?Model
    {
        return $this->getQuery($scopes)
            ->first();
    }

    /**
     * @param Scope[] $scopes
     */
    protected function getOrFail(array $scopes = []): Model
    {
        return $this->getQuery($scopes)
            ->firstOrFail();
    }

    /**
     * @param Scope[] $scopes
     */
    protected function find(string|int $id, array $scopes = []): ?Model
    {
        /** @var Model|null $model */
        $model = $this->getQuery($scopes)
            ->find($id);

        return $model;
    }

    /**
     * @param Scope[] $scopes
     */
    protected function findOrFail(string|int $id, array $scopes = []): Model
    {
        /** @var Model $model */
        $model = $this->getQuery($scopes)
            ->findOrFail($id);

        return $model;
    }

    /**
     * @param Scope[] $scopes
     */
    protected function getQuery(array $scopes = []): Builder
    {
        $class = $this->getModelClass();

        return $this->getScopedQuery($class::query(), $scopes);
    }

    protected function getIdColumn(): string
    {
        $modelClass = $this->getModelClass();

        return (new $modelClass())->getKeyName();
    }

    /**
     * @param Scope[]|null[]|null $scopes
     */
    protected function getScopedQuery(Builder $query, ?array $scopes): Builder
    {
        if ($scopes === null) {
            return $query;
        }

        foreach ($scopes as $i => $scope) {
            if ($scope === null) {
                continue;
            }

            $query->withGlobalScope($i, $scope);
        }

        return $query;
    }
}
