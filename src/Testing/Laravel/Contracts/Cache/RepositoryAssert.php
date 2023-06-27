<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;
use DateInterval;
use DateTimeInterface;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Cache\Store;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class RepositoryAssert extends AbstractExpectationCallsMap implements Repository
{
    /**
     * @param array<RepositoryPullExpectation|null> $pull
     * @param array<RepositoryPutExpectation|null> $put
     * @param array<RepositoryAddExpectation|null> $add
     * @param array<RepositoryIncrementExpectation|null> $increment
     * @param array<RepositoryDecrementExpectation|null> $decrement
     * @param array<RepositoryForeverExpectation|null> $forever
     * @param array<RepositoryRememberExpectation|null> $remember
     * @param array<RepositorySearExpectation|null> $sear
     * @param array<RepositoryRememberForeverExpectation|null> $rememberForever
     * @param array<RepositoryForgetExpectation|null> $forget
     * @param array<RepositoryGetStoreExpectation|null> $getStore
     * @param array<RepositoryGetExpectation|null> $get
     * @param array<RepositorySetExpectation|null> $set
     * @param array<RepositoryDeleteExpectation|null> $delete
     * @param array<RepositoryClearExpectation|null> $clear
     * @param array<RepositoryGetMultipleExpectation|null> $getMultiple
     * @param array<RepositorySetMultipleExpectation|null> $setMultiple
     * @param array<RepositoryDeleteMultipleExpectation|null> $deleteMultiple
     * @param array<RepositoryHasExpectation|null> $has
     */
    public function __construct(
        array $pull = [],
        array $put = [],
        array $add = [],
        array $increment = [],
        array $decrement = [],
        array $forever = [],
        array $remember = [],
        array $sear = [],
        array $rememberForever = [],
        array $forget = [],
        array $getStore = [],
        array $get = [],
        array $set = [],
        array $delete = [],
        array $clear = [],
        array $getMultiple = [],
        array $setMultiple = [],
        array $deleteMultiple = [],
        array $has = [],
    ) {
        parent::__construct();
        $this->setExpectations(RepositoryPullExpectation::class, $pull);
        $this->setExpectations(RepositoryPutExpectation::class, $put);
        $this->setExpectations(RepositoryAddExpectation::class, $add);
        $this->setExpectations(RepositoryIncrementExpectation::class, $increment);
        $this->setExpectations(RepositoryDecrementExpectation::class, $decrement);
        $this->setExpectations(RepositoryForeverExpectation::class, $forever);
        $this->setExpectations(RepositoryRememberExpectation::class, $remember);
        $this->setExpectations(RepositorySearExpectation::class, $sear);
        $this->setExpectations(RepositoryRememberForeverExpectation::class, $rememberForever);
        $this->setExpectations(RepositoryForgetExpectation::class, $forget);
        $this->setExpectations(RepositoryGetStoreExpectation::class, $getStore);
        $this->setExpectations(RepositoryGetExpectation::class, $get);
        $this->setExpectations(RepositorySetExpectation::class, $set);
        $this->setExpectations(RepositoryDeleteExpectation::class, $delete);
        $this->setExpectations(RepositoryClearExpectation::class, $clear);
        $this->setExpectations(RepositoryGetMultipleExpectation::class, $getMultiple);
        $this->setExpectations(RepositorySetMultipleExpectation::class, $setMultiple);
        $this->setExpectations(RepositoryDeleteMultipleExpectation::class, $deleteMultiple);
        $this->setExpectations(RepositoryHasExpectation::class, $has);
    }

    /**
     * Retrieve an item from the cache and delete it.
     *
     * @template TCacheValue
     *
     * @param  array|string  $key
     * @param TCacheValue|Closure():TCacheValue $default
     * @return (TCacheValue is null ? mixed : TCacheValue)
     */
    public function pull($key, $default = null)
    {
        $expectation = $this->getExpectation(RepositoryPullExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->default, $default, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $default, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Store an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param DateTimeInterface|DateInterval|int|null $ttl
     * @return bool
     */
    public function put($key, $value, $ttl = null)
    {
        $expectation = $this->getExpectation(RepositoryPutExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->value, $value, $message);
        Assert::assertEquals($expectation->ttl, $ttl, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $value, $ttl, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Store an item in the cache if the key does not exist.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param DateTimeInterface|DateInterval|int|null $ttl
     * @return bool
     */
    public function add($key, $value, $ttl = null)
    {
        $expectation = $this->getExpectation(RepositoryAddExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->value, $value, $message);
        Assert::assertEquals($expectation->ttl, $ttl, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $value, $ttl, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    public function increment($key, $value = 1): int|bool
    {
        $expectation = $this->getExpectation(RepositoryIncrementExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->value, $value, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $value, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    public function decrement($key, $value = 1): int|bool
    {
        $expectation = $this->getExpectation(RepositoryDecrementExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->value, $value, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $value, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return bool
     */
    public function forever($key, $value)
    {
        $expectation = $this->getExpectation(RepositoryForeverExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->value, $value, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $value, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @template TCacheValue
     *
     * @param  string  $key
     * @param DateTimeInterface|DateInterval|int|null $ttl
     * @param Closure():TCacheValue $callback
     * @return TCacheValue
     */
    public function remember($key, $ttl, Closure $callback)
    {
        $expectation = $this->getExpectation(RepositoryRememberExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->ttl, $ttl, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $ttl, $callback, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @template TCacheValue
     *
     * @param  string  $key
     * @param Closure():TCacheValue $callback
     * @return TCacheValue
     */
    public function sear($key, Closure $callback)
    {
        $expectation = $this->getExpectation(RepositorySearExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $callback, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @template TCacheValue
     *
     * @param  string  $key
     * @param Closure():TCacheValue $callback
     * @return TCacheValue
     */
    public function rememberForever($key, Closure $callback)
    {
        $expectation = $this->getExpectation(RepositoryRememberForeverExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $callback, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function forget($key)
    {
        $expectation = $this->getExpectation(RepositoryForgetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Get the cache store implementation.
     *
     * @return Store
     */
    public function getStore()
    {
        $expectation = $this->getExpectation(RepositoryGetStoreExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Fetches a value from the cache.
     *
     * @param string $key     The unique key of this item in the cache.
     * @param mixed  $default Default value to return if the key does not exist.
     *
     * @return mixed The value of the item from the cache, or $default in case of cache miss.
     */
    public function get($key, mixed $default = null): mixed
    {
        $expectation = $this->getExpectation(RepositoryGetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->default, $default, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $default, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
     *
     * @param string                 $key   The key of the item to store.
     * @param mixed                  $value The value of the item to store, must be serializable.
     * @param null|int|DateInterval $ttl Optional. The TTL value of this item. If no value is sent and
     * the driver supports TTL then the library may set a default value
     * for it or let the driver take care of that.
     *
     * @return bool True on success and false on failure.
     */
    public function set($key, $value, $ttl = null): bool
    {
        $expectation = $this->getExpectation(RepositorySetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->value, $value, $message);
        Assert::assertEquals($expectation->ttl, $ttl, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $value, $ttl, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key The unique cache key of the item to delete.
     *
     * @return bool True if the item was successfully removed. False if there was an error.
     */
    public function delete(string $key): bool
    {
        $expectation = $this->getExpectation(RepositoryDeleteExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @return bool True on success and false on failure.
     */
    public function clear(): bool
    {
        $expectation = $this->getExpectation(RepositoryClearExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param iterable<string> $keys    A list of keys that can be obtained in a single operation.
     * @param mixed            $default Default value to return for keys that do not exist.
     *
     * @return iterable<string, mixed> A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $expectation = $this->getExpectation(RepositoryGetMultipleExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->keys, $keys, $message);
        Assert::assertEquals($expectation->default, $default, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $keys, $default, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     *
     * @param iterable               $values A list of key => value pairs for a multiple-set operation.
     * @param null|int|DateInterval $ttl Optional. The TTL value of this item. If no value is sent and
     * the driver supports TTL then the library may set a default value
     * for it or let the driver take care of that.
     *
     * @return bool True on success and false on failure.
     */
    public function setMultiple(iterable $values, DateInterval|int|null $ttl = null): bool
    {
        $expectation = $this->getExpectation(RepositorySetMultipleExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->values, $values, $message);
        Assert::assertEquals($expectation->ttl, $ttl, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $values, $ttl, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param iterable<string> $keys A list of string-based keys to be deleted.
     *
     * @return bool True if the items were successfully removed. False if there was an error.
     */
    public function deleteMultiple(iterable $keys): bool
    {
        $expectation = $this->getExpectation(RepositoryDeleteMultipleExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->keys, $keys, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $keys, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Determines whether an item is present in the cache.
     *
     * NOTE: It is recommended that has() is only to be used for cache warming type purposes and not to be used within
     * your live applications operations for get/set, as this method is subject to a race condition where your has()
     * will return true and immediately after, another script can remove it making the state of your app out of date.
     *
     * @param string $key The cache item key.
     */
    public function has(string $key): bool
    {
        $expectation = $this->getExpectation(RepositoryHasExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $expectation);
        }

        return $expectation->return;
    }
}
