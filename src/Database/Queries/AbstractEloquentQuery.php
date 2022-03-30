<?php

declare(strict_types=1);

namespace Larastrict\Database\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Scope;

/**
 * You must implement abstract public function execute.
 *
 * @template T of Model
 */
abstract class AbstractEloquentQuery extends AbstractQuery
{
    /**
     * @return class-string<T>
     */
    abstract protected function getModelClass(): string;

    /**
     * @param Scope[] $scopes
     */
    protected function chunk(array $scopes = []): ChunkedModelQueryResult
    {
        return new ChunkedModelQueryResult(
            $this->getModelClass(),
            $this->getQuery($scopes)
        );
    }

    /**
     * @param Scope[] $scopes
     *
     * @return Collection<T>
     */
    protected function getAll(array $scopes = []): Collection
    {
        return $this->getQuery($scopes)->get();
    }

    /**
     * @param Scope[] $scopes
     *
     * @return T|null
     */
    protected function get(array $scopes = []): ?Model
    {
        return $this->getQuery($scopes)->first();
    }

    /**
     * @param Scope[] $scopes
     *
     * @return T
     *
     * @throws ModelNotFoundException
     */
    protected function getOrFail(array $scopes = []): Model
    {
        return $this->getQuery($scopes)->firstOrFail();
    }

    /**
     * @param Scope[] $scopes
     *
     * @return T|null
     */
    protected function find(string|int $id, array $scopes = []): ?Model
    {
        return $this->getQuery($scopes)->find($id);
    }

    /**
     * @param Scope[] $scopes
     *
     * @return T
     */
    protected function findOrFail(string|int $id, array $scopes = []): Model
    {
        return $this->getQuery($scopes)->findOrFail($id);
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
}
