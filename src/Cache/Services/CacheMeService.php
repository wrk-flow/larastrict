<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Services;

use Closure;
use Illuminate\Cache\Repository;
use Illuminate\Cache\TaggedCache;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraStrict\Cache\Constants\CacheExpirations;
use LaraStrict\Cache\Contracts\CacheMeServiceContract;
use LaraStrict\Cache\Enums\CacheDriver;
use LaraStrict\Cache\Enums\CacheMeStrategy;
use LaraStrict\Cache\Exceptions\CacheTagsNotSupportedException;
use Psr\Log\LoggerInterface;

class CacheMeService implements CacheMeServiceContract
{
    public function __construct(
        private readonly Factory $cacheFactory,
        private readonly LoggerInterface $logger,
        private readonly Container $container
    ) {
    }

    /**
     * Stores in memory and uses the default cache.
     */
    public function get(
        string $key,
        Closure $getValue,
        array $tags = [],
        int $minutes = CacheExpirations::HalfDay,
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository
    ): mixed {
        if ($strategy === CacheMeStrategy::None) {
            return $this->container->call($getValue);
        }

        $value = null;
        $repositories = $this->repositories($tags, $strategy);
        $hasMoreRepositories = count($repositories) > 1;

        foreach ($repositories as $index => $repository) {
            $value = $repository->get($key);

            // If we have found a value then prevent fetching the data from other repositories.
            if ($value === null) {
                continue;
            }

            // We need to update our previous stores to allow next "call" to use the faster
            // store (memory).
            if ($hasMoreRepositories && $index !== 0) {
                $updateRepositories = [];
                foreach ($repositories as $subIndex => $subRepository) {
                    if ($subIndex === $index) {
                        break;
                    }

                    $updateRepositories[] = $subRepository;
                }

                // Do not spam log
                $this->store($updateRepositories, $key, $value, $tags, $minutes, false);
            }

            break;
        }

        // If the result is still null it means that the value is not in cache, build it and
        // store it
        if ($value === null) {
            $value = $this->container->call($getValue);

            if ($value !== null) {
                $this->store($repositories, $key, $value, $tags, $minutes);
            }
        }

        return $value;
    }

    /**
     * Stores given value to cache stores with given strategy.
     */
    public function set(
        string $key,
        mixed $value,
        array $tags = [],
        int $minutes = CacheExpirations::HalfDay,
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository
    ): void {
        $this->store($this->repositories($tags, $strategy), $key, $value, $tags, $minutes);
    }

    /**
     * Flush cache for given tags (optional).
     *
     * Beware that this will cause queue flush too if using redis!
     */
    public function flush(
        array $tags = [],
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository
    ): void {
        $this->logger->debug('Flushing cache', [
            'tags' => $tags,
            'strategy' => $strategy->value,
        ]);

        foreach ($this->repositories($tags, $strategy) as $repository) {
            if ($repository instanceof TaggedCache) {
                $repository->flush();
            } else {
                $repository->clear();
            }
        }
    }

    /**
     * Deletes exact key withing the tags.
     */
    public function delete(
        string $key,
        array $tags = [],
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository
    ): void {
        $this->logger->debug('Deleting cache', [
            'tags' => $tags,
            'key' => $key,
            'strategy' => $strategy,
        ]);

        foreach ($this->repositories($tags, $strategy) as $store) {
            $store->delete($key);
        }
    }

    /**
     * Adds a observe functions for created/deleted/updated/restored and flushes the cache by giving a list of tags.
     *
     * @template T of Model
     *
     * @param array|Closure(T):void $tags       If closure, model is passed to the closure. Closure should return an array
     * of tags to use. If empty, no flush will be done.
     * @param class-string<T>       $modelClass
     */
    public function observeAndFlush(array|Closure $tags, string $modelClass): void
    {
        $modelClass::created(function ($model) use ($tags): void {
            $this->tryToFlushWithModel($model, $tags);
        });
        $modelClass::deleted(function ($model) use ($tags): void {
            $this->tryToFlushWithModel($model, $tags);
        });
        $modelClass::updated(function ($model) use ($tags): void {
            $this->tryToFlushWithModel($model, $tags);
        });

        $uses = class_uses($modelClass);
        if (is_array($uses) && array_key_exists(SoftDeletes::class, $uses)) {
            /** @var SoftDeletes $modelClass */
            /* @phpstan-ignore-next-line */
            $modelClass::restored(function ($model) use ($tags): void {
                $this->tryToFlushWithModel($model, $tags);
            });
        }
    }

    /**
     * Returns store for accessing data. Key-ed by CacheDriver.
     *
     * @return array<CacheContract>
     */
    protected function repositories(
        array $tags = [],
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository
    ): array {
        $stores = [];

        if ($strategy === CacheMeStrategy::None) {
            return $stores;
        }

        // Memory must be first to prevent calling redis.
        if ($strategy === CacheMeStrategy::Memory
            || $strategy === CacheMeStrategy::MemoryAndRepository) {
            $stores[] = $this->cacheFactory->store(CacheDriver::Array->value);
        }

        // Get default store
        if ($strategy === CacheMeStrategy::Repository
            || $strategy === CacheMeStrategy::MemoryAndRepository) {
            $repository = $this->cacheFactory->store();

            if ($repository instanceof Repository === false) {
                $this->logger->warning('Un-supported repository storage');
            } elseif ($tags !== []) {
                if ($repository->supportsTags() === false) {
                    throw new CacheTagsNotSupportedException();
                }

                $stores[] = $repository->tags($tags);
            } else {
                $stores[] = $repository;
            }
        }

        return $stores;
    }

    /**
     * @param array<int,CacheContract> $repositories
     */
    protected function store(
        array $repositories,
        string $key,
        mixed $value,
        array $tags = [],
        int $minutes = CacheExpirations::HalfDay,
        bool $log = true
    ): void {
        if ($repositories === []) {
            return;
        }

        if ($log) {
            $this->logger->debug('Storing cache', [
                'key' => $key,
                'minutes' => $minutes,
                'tags' => $tags,
                'store' => array_map(fn (CacheContract $store) => $store->getStore()::class, $repositories),
            ]);
        }

        foreach ($repositories as $store) {
            $store->set($key, $value, $minutes);
        }
    }

    /**
     * Flushes the cache with given model and tags.
     *
     * @param array|Closure $tags If closure, model is passed to the closure. Closure should return an array
     * of tags to use. If empty, no flush will be done.
     */
    protected function tryToFlushWithModel(Model $model, array|Closure $tags): void
    {
        if (is_callable($tags)) {
            $tags = $tags($model);
        }

        if (empty($tags)) {
            return;
        }

        $this->flush($tags);
    }
}
