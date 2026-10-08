<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Cache\Constants\CacheExpirations;
use LaraStrict\Cache\Enums\CacheMeStrategy;

interface CacheMeServiceContract
{
    /**
     * Tries to get the value from the cache using given strategy (by default tries memory and then repository). If
     * value does not exist, creates it via callback. If repository supports tags it will use tagged store.
     *
     * @template T
     * @param Closure(mixed...):T $getValue method is called with dependency injection
     * @phpstan-param Closure(mixed,mixed,mixed,mixed,mixed,mixed):T $getValue
     * @return T
     * @param list<string> $tags
     */
    public function get(
        string $key,
        Closure $getValue,
        array $tags = [],
        int $seconds = CacheExpirations::Day,
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
        bool $log = true,
    ): mixed;

    /**
     * Stores given value to cache.
     * @param list<string> $tags
     */
    public function set(
        string $key,
        mixed $value,
        array $tags = [],
        int $seconds = CacheExpirations::Day,
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
        bool $log = true,
    ): void;

    /**
     * Flush cache for given tags (optional).
     * @param list<string> $tags
     */
    public function flush(array $tags = [], CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository): void;

    /**
     * Deletes exact key within the tags.
     * @param list<string> $tags
     */
    public function delete(
        string $key,
        array $tags = [],
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
    ): void;

    /**
     * Adds a observe functions for created/deleted/updated and flushes the cache.
     *
     * @param list<string>|Closure(Model):list<string> $tags If closure, model is passed to the closure. Closure should return a list
     * of tags to use. If empty, no flush will be done.
     * @param class-string<Model> $modelClass
     */
    public function observeAndFlush(array|Closure $tags, string $modelClass): void;
}
