<?php

declare(strict_types=1);

namespace LaraStrict\Database\Queries;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class ChunkedModelQueryResult
{
    /**
     * @var Closure(TModel):mixed|null
     */
    protected Closure|null $onEntryTransform = null;

    /**
     * @param class-string<TModel> $modelClass At this moment this PHP storm does not "typehint" closure. But this should
     *                                         probably work. Maybe psalm in composer needs to be set.
     */
    public function __construct(
        public readonly string $modelClass,
        public readonly Builder $query
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
     * @param Closure(Collection<int,TModel>):void $closure
     */
    public function onChunkById(Closure $closure, ?int $count = null): bool
    {
        $count ??= 100;

        return $this->query
            ->chunkById($count, $closure);
    }

    /**
     * @param Closure(TModel): void $closure
     *
     * @return int number of processed entries
     */
    public function onEntryById(Closure $closure, ?int $count = null): int
    {
        $processed = 0;
        $this->onChunkById(
            function (Collection $collection) use ($closure, &$processed): void {
                ++$processed;
                foreach ($collection as $entry) {
                    $wrappedEntry = $this->onEntryTransform === null
                        ? $entry
                        : call_user_func($this->onEntryTransform, $entry);

                    $closure($wrappedEntry);
                }
            },
            $count
        );

        return $processed;
    }
}
