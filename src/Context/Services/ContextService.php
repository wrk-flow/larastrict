<?php

declare(strict_types=1);

namespace LaraStrict\Context\Services;

use Closure;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Container\Container;
use LaraStrict\Cache\Contracts\CacheMeServiceContract;
use LaraStrict\Cache\Enums\CacheMeStrategy;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contexts\AbstractIsContext;
use LaraStrict\Context\Contracts\ContextValueContract;
use LaraStrict\Context\Values\BoolContextValue;

/**
 * Shareable context values between logic that needs same data. Stored in memory and if context supports its it will
 * stores in cache repository (only usable with boot).
 */
class ContextService
{
    /**
     * @var string
     */
    protected const TAG = 'context';

    public function __construct(
        private readonly ContextCallService $callService,
        private readonly CacheMeServiceContract $cacheMeManager
    ) {
    }

    public function delete(AbstractContext $context): void
    {
        $fullCacheKey = $this->getCacheKey($context);

        $this->cacheMeManager->delete(key: $fullCacheKey, strategy: $this->cacheStrategy($context));
    }

    /**
     * Stores state to memory (and cache if supported).
     */
    public function set(AbstractContext $context, ContextValueContract $value): void
    {
        $fullCacheKey = $this->getCacheKey($context);

        $this->cacheMeManager->set(
            key: $fullCacheKey,
            value: $value,
            tags: [self::TAG],
            minutes: $context->getCacheTtl()
        );
    }

    public function setWithoutCache(AbstractContext $context, ContextValueContract $value): void
    {
        $fullCacheKey = $this->getCacheKey($context);

        $this->cacheMeManager->set(
            key: $fullCacheKey,
            value: $value,
            tags: [self::TAG],
            minutes: $context->getCacheTtl(),
            strategy: CacheMeStrategy::Memory
        );
    }

    /**
     * @template T of  ContextValueContract
     *
     * @param Closure(mixed,mixed,mixed): T $createState Create the state
     * @return T
     */
    public function get(AbstractContext $context, Closure $createState): ContextValueContract
    {
        $fullCacheKey = $this->getCacheKey($context);

        return $this->cacheMeManager->get(
            key: $fullCacheKey,
            getValue: fn () => $this->callService->createState($context, $createState),
            tags: [self::TAG],
            minutes: $context->getCacheTtl(),
            strategy: $this->cacheStrategy($context)
        );
    }

    /**
     * Returns bool state of the context.
     *
     * @param Closure():bool $is
     */
    public function is(AbstractIsContext $context, Closure $is): BoolContextValue
    {
        return $this->get($context, fn (Container $container) => new BoolContextValue((bool) $container->call($is)));
    }

    public function getCacheKey(AbstractContext $context): string
    {
        return $context::class . '-' . $context->getCacheKey();
    }

    protected function cacheStrategy(AbstractContext $context): CacheMeStrategy
    {
        return $context->useCache()
            ? CacheMeStrategy::MemoryAndRepository
            : CacheMeStrategy::Memory;
    }
}
