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
     * @param class-string<TModel> $modelClass At this moment this PHP storm does not "typehint" closure. But this should
     *                                    probably work. Maybe psalm in composer needs to be set.
     */
    public function __construct(
        public readonly string $modelClass,
        public readonly Builder $query
    ) {
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
                    $closure($entry);
                }
            },
            $count
        );

        return $processed;
    }
}
