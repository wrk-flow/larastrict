<?php

declare(strict_types=1);

namespace LaraStrict\Database\Queries;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @todo deprecate in favor of Generator
 */
class ChunkedModelQueryResult
{
    /**
     * @var Closure(TModel):mixed|null
     */
    protected Closure|null $onEntryTransform = null;

    /**
     * @param class-string<TModel> $modelClass At this moment this PHP storm does not "typehint" closure. But this
     *                                         should probably work. Maybe psalm in composer needs to be set.
     */
    public function __construct(
        public readonly string $modelClass,
        public readonly Builder $query,
        public readonly bool $chunkById = true
    ) {
    }

    /**
     * Sometimes you want to automatically transform model to your entity.
     *
     * TODO: maybe we can disable "model" transform and use this (toQuery()->...)
     *
     * @param Closure(TModel):mixed|null $onEntryTransform
     *
     * @return $this
     */
    public function setTransformOnEntry(Closure|null $onEntryTransform): self
    {
        $this->onEntryTransform = $onEntryTransform;

        return $this;
    }

    /**
     * Loads a chunk of models using closure.
     *
     * @param Closure(Collection<int,TModel>):void $closure closure that will receive a collection of models
     */
    public function onChunk(Closure $closure, ?int $count = null): bool
    {
        $count ??= 100;

        $this->query->applyScopes();

        if ($this->chunkById) {
            return $this->query->chunkById($count, $closure);
        }

        return $this->query->chunk($count, $closure);
    }

    /**
     * Loads a chunk of models and calls $closure with only ids. Ideal to combine with SelectScope.
     *
     * @param Closure(array<int|string>):void $closure
     */
    public function onKeys(Closure $closure, ?int $count = null): bool
    {
        return $this->onChunk(
            closure: static function (Collection $collection) use ($closure): void {
                $keys = [];
                /** @var Model $model */
                foreach ($collection as $model) {
                    $keys[] = $model->getKey();
                }

                $closure($keys);
            },
            count: $count
        );
    }

    /**
     * Loads a chunk of models and with closure that will receive each model from the chunks.
     *
     * @param Closure(TModel): void $closure closure that will receive a model from all the chunks
     *
     * @return int number of processed entries
     */
    public function onEntry(Closure $closure, ?int $count = null): int
    {
        $processed = 0;
        $this->onChunk(
            function (Collection $collection) use ($closure, &$processed): void {
                foreach ($collection as $entry) {
                    $wrappedEntry = $this->onEntryTransform instanceof Closure
                        ? call_user_func($this->onEntryTransform, $entry)
                        : $entry;

                    $closure($wrappedEntry);
                    ++$processed;
                }
            },
            $count
        );

        return $processed;
    }
}
