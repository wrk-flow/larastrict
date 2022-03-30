<?php

declare(strict_types=1);

namespace Larastrict\Database\Queries;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @template T
 */
class ChunkedModelQueryResult
{
    public readonly Builder $query;
    /**
     * @var class-string<T>
     */
    public readonly string $modelClass;

    /**
     * @param class-string<T> $modelClass At this moment this PHP storm does not "typehint" closure. But this should
     *                                    probably work. Maybe psalm in composer needs to be set.
     */
    public function __construct(string $modelClass, Builder $builder)
    {
        $this->query = $builder;
        $this->modelClass = $modelClass;
    }

    /**
     * @param Closure(Collection<T>): void $closure
     */
    public function onChunkById(
        Closure $closure,
        ?int $count = null
    ): bool {
        $count ??= 100;

        return $this->query
            ->chunkById(
                $count,
                $closure
            );
    }

    /**
     * @param Closure(T): void $closure
     *
     * @return int number of processed entries
     */
    public function onEntryById(
        Closure $closure,
        ?int $count = null
    ): int {
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
