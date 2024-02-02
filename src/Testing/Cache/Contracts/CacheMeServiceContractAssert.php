<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Cache\Constants\CacheExpirations;
use LaraStrict\Cache\Contracts\CacheMeServiceContract;
use LaraStrict\Cache\Enums\CacheMeStrategy;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class CacheMeServiceContractAssert extends AbstractExpectationCallsMap implements CacheMeServiceContract
{
    /**
     * @param array<CacheMeServiceContractGetExpectation|null> $get
     * @param array<CacheMeServiceContractSetExpectation|null> $set
     * @param array<CacheMeServiceContractFlushExpectation|null> $flush
     * @param array<CacheMeServiceContractDeleteExpectation|null> $delete
     * @param array<CacheMeServiceContractObserveAndFlushExpectation|null> $observeAndFlush
     */
    public function __construct(
        array $get = [],
        array $set = [],
        array $flush = [],
        array $delete = [],
        array $observeAndFlush = [],
    ) {
        parent::__construct();
        $this->setExpectations(CacheMeServiceContractGetExpectation::class, $get);
        $this->setExpectations(CacheMeServiceContractSetExpectation::class, $set);
        $this->setExpectations(CacheMeServiceContractFlushExpectation::class, $flush);
        $this->setExpectations(CacheMeServiceContractDeleteExpectation::class, $delete);
        $this->setExpectations(CacheMeServiceContractObserveAndFlushExpectation::class, $observeAndFlush);
    }

    /**
     * Tries to get the value from the cache using given strategy (by default tries memory and then repository). If
     * value does not exist, creates it via callback. If repository supports tags it will use tagged store.
     *
     * @param Closure $getValue method is called with dependency injection
     */
    public function get(
        string $key,
        Closure $getValue,
        array $tags = [],
        int $seconds = CacheExpirations::Day,
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
        bool $log = true,
    ): mixed {
        $expectation = $this->getExpectation(CacheMeServiceContractGetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->tags, $tags, $message);
        Assert::assertEquals($expectation->minutes, $seconds, $message);
        Assert::assertEquals($expectation->strategy, $strategy, $message);
        Assert::assertEquals($expectation->log, $log, $message);

        $callGetValueHook = $expectation->callGetValueHook;

        return $callGetValueHook instanceof Closure === false ? $getValue() : $callGetValueHook($getValue);
    }

    /**
     * Stores given value to cache.
     */
    public function set(
        string $key,
        mixed $value,
        array $tags = [],
        int $seconds = CacheExpirations::Day,
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
        bool $log = true,
    ): void {
        $expectation = $this->getExpectation(CacheMeServiceContractSetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->value, $value, $message);
        Assert::assertEquals($expectation->tags, $tags, $message);
        Assert::assertEquals($expectation->minutes, $seconds, $message);
        Assert::assertEquals($expectation->strategy, $strategy, $message);
        Assert::assertEquals($expectation->log, $log, $message);
    }

    /**
     * Flush cache for given tags (optional).
     */
    public function flush(
        array $tags = [],
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
    ): void {
        $expectation = $this->getExpectation(CacheMeServiceContractFlushExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->tags, $tags, $message);
        Assert::assertEquals($expectation->strategy, $strategy, $message);
    }

    /**
     * Deletes exact key within the tags.
     */
    public function delete(
        string $key,
        array $tags = [],
        CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
    ): void {
        $expectation = $this->getExpectation(CacheMeServiceContractDeleteExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->tags, $tags, $message);
        Assert::assertEquals($expectation->strategy, $strategy, $message);
    }

    /**
     * Adds a observe functions for created/deleted/updated and flushes the cache.
     *
     * @param array|Closure       $tags       If closure, model is passed to the closure. Closure should return an array
     * of tags to use. If empty, no flush will be done.
     * @param class-string<Model> $modelClass
     */
    public function observeAndFlush(Closure|array $tags, string $modelClass): void
    {
        $expectation = $this->getExpectation(CacheMeServiceContractObserveAndFlushExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->tags, $tags, $message);
        Assert::assertEquals($expectation->modelClass, $modelClass, $message);
    }
}
