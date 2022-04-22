<?php

declare(strict_types=1);

namespace LaraStrict\Database\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Arr;

/**
 * You must implement abstract public function execute.
 *
 * @template TModel of Model
 */
abstract class AbstractEloquentQuery extends AbstractQuery
{
    public function getKeyColumn(): string
    {
        $modelClass = $this->getModelClass();

        return (new $modelClass())->getKeyName();
    }

    /**
     * @return class-string<TModel>
     */
    abstract protected function getModelClass(): string;

    /**
     * @param Scope[] $scopes
     *
     * @return ChunkedModelQueryResult<TModel>
     */
    protected function chunk(array $scopes = [], array $orderBy = []): ChunkedModelQueryResult
    {
        $modelClass = $this->getModelClass();
        $query = $this->getQuery($scopes);

        $chunkById = $orderBy === [];

        if ($chunkById === false) {
            $model = new $modelClass();
            foreach ($orderBy as $scope) {
                $scope->apply($query, $model);
            }
        }

        return new ChunkedModelQueryResult($modelClass, $query, $chunkById);
    }

    /**
     * Inserts given items in batch with automatic chunking to prevent maximum placeholder error.
     *
     * @param int $columnsCount Maximum placeholders / number of columns. Uses count on first item.
     */
    protected function chunkWrite(array $items, int $columnsCount = 0): void
    {
        if ($items === []) {
            return;
        }

        if ($columnsCount === 0) {
            $columnsCount = is_countable(Arr::first($items)) ? count(Arr::first($items)) : 0;
        }

        // We need to prevent insert max statements by limiting number of insert
        $maxChunkSize = (int) (65536 / $columnsCount);
        $modelClass = $this->getModelClass();

        foreach (array_chunk($items, max(1, $maxChunkSize)) as $pricesInChunk) {
            $modelClass::insert($pricesInChunk);
        }
    }

    /**
     * @param Scope[] $scopes
     *
     * @return Collection<int, TModel>
     */
    protected function getAll(array $scopes = []): Collection
    {
        return $this->getQuery($scopes)
            ->get();
    }

    /**
     * @param Scope[] $scopes
     *
     * @return TModel|null
     */
    protected function get(array $scopes = []): ?Model
    {
        return $this->getQuery($scopes)
            ->first();
    }

    /**
     * @param Scope[] $scopes
     *
     * @return TModel
     */
    protected function getOrFail(array $scopes = []): Model
    {
        return $this->getQuery($scopes)
            ->firstOrFail();
    }

    /**
     * @param Scope[] $scopes
     *
     * @return TModel|null
     */
    protected function find(string|int $id, array $scopes = []): ?Model
    {
        /** @var TModel|null $model */
        $model = $this->getQuery($scopes)
            ->find($id);

        return $model;
    }

    /**
     * @param Scope[] $scopes
     *
     * @return TModel
     */
    protected function findOrFail(string|int $id, array $scopes = []): Model
    {
        /** @var TModel $model */
        $model = $this->getQuery($scopes)
            ->findOrFail($id);

        return $model;
    }

    /**
     * @param Scope[] $scopes
     *
     * @return TModel
     */
    protected function delete(array $scopes = []): mixed
    {
        return $this->getQuery($scopes)
            ->delete();
    }

    /**
     * @param Scope[] $scopes
     *
     * @return TModel
     */
    protected function forceDelete(array $scopes = []): mixed
    {
        return $this->getQuery($scopes)
            ->forceDelete();
    }

    /**
     * @param Scope[] $scopes
     *
     * @return Builder<TModel>
     */
    protected function getQuery(array $scopes = []): Builder
    {
        $class = $this->getModelClass();

        return $this->getScopedQuery($class::query(), $scopes);
    }

    /**
     * @param Builder<TModel>     $query
     * @param Scope[]|null[]|null $scopes
     *
     * @return Builder<TModel>
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
