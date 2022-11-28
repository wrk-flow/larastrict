<?php

declare(strict_types=1);

namespace LaraStrict\Database\Queries;

use Closure;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Arr;
use LaraStrict\Database\Scopes\OrderScope;

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
     * @return TModel
     */
    public function make(array $attributes = []): Model
    {
        $modelClass = $this->getModelClass();

        return new $modelClass($attributes);
    }

    /**
     * @return class-string<TModel>
     */
    abstract protected function getModelClass(): string;

    /**
     * @param Scope[]           $scopes
     * @param array<OrderScope> $orderBy
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
     * @return Collection<int,TModel>
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
     * @return LengthAwarePaginator<TModel>
     */
    protected function paginate(array $scopes = [], ?int $perPage = null): LengthAwarePaginator
    {
        return $this->getQuery($scopes)
            ->paginate($perPage);
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
     * @param Scope[]                            $scopes
     * @param Closure(int|string):Exception|null $customException Creates a custom exceptions if model does not exists.
     *                                                            Receives $id argument.
     *
     * @return TModel
     */
    protected function findOrFail(string|int $key, array $scopes = [], Closure $customException = null): Model
    {
        try {
            /** @var TModel $model */
            $model = $this->getQuery($scopes)
                ->findOrFail($key);

            return $model;
        } catch (ModelNotFoundException $modelNotFoundException) {
            if ($customException === null) {
                throw $modelNotFoundException;
            }

            throw $customException($key);
        }
    }

    /**
     * @param Scope[] $scopes
     */
    protected function delete(array $scopes = []): int
    {
        $delete = $this->getQuery($scopes)
            ->delete();

        if (is_int($delete)) {
            return $delete;
        }

        return 0;
    }

    /**
     * @param Scope[] $scopes
     */
    protected function forceDelete(array $scopes = []): int
    {
        $delete = $this->getQuery($scopes)
            ->forceDelete();

        if (is_int($delete)) {
            return $delete;
        }

        return 0;
    }

    /**
     * @param Scope[] $scopes
     *
     * @return Builder<TModel>
     */
    protected function getQuery(array $scopes = []): Builder
    {
        $class = $this->getModelClass();
        /** @var Builder<TModel> $query */
        $query = $class::query();
        return $this->getScopedQuery($query, $scopes);
    }
}
