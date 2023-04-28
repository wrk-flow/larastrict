<?php

declare(strict_types=1);

namespace LaraStrict\Context\Services;

use Closure;
use Illuminate\Contracts\Container\Container;
use LaraStrict\Cache\Contracts\CacheMeServiceContract;
use LaraStrict\Cache\Enums\CacheMeStrategy;
use LaraStrict\Context\Concerns\UseCache;
use LaraStrict\Context\Concerns\UseCacheWithTags;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contexts\AbstractIsContext;
use LaraStrict\Context\Contracts\ContextServiceContract;
use LaraStrict\Context\Contracts\ContextValueContract;
use LaraStrict\Context\Values\BoolContextValue;
use LaraStrict\Core\Services\ImplementsService;

class ContextService implements ContextServiceContract
{
    protected const TAG = 'context';

    public function __construct(
        private readonly CacheMeServiceContract $cacheMeManager,
        private readonly ImplementsService $implementsService
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
            tags: $this->getTags($context),
            minutes: $context->getCacheTtl(),
        );
    }

    public function setWithoutCache(AbstractContext $context, ContextValueContract $value): void
    {
        $fullCacheKey = $this->getCacheKey($context);

        $this->cacheMeManager->set(
            key: $fullCacheKey,
            value: $value,
            tags: $this->getTags($context),
            minutes: $context->getCacheTtl(),
            strategy: CacheMeStrategy::Memory,
        );
    }

    public function get(AbstractContext $context, Closure $createState): ContextValueContract
    {
        $fullCacheKey = $this->getCacheKey($context);

        return $this->cacheMeManager->get(
            key: $fullCacheKey,
            getValue: $createState,
            tags: $this->getTags($context),
            minutes: $context->getCacheTtl(),
            strategy: $this->cacheStrategy($context)
        );
    }

    public function is(AbstractIsContext $context, Closure $is): BoolContextValue
    {
        return $this->get(
            context: $context,
            createState: static fn (Container $container) => new BoolContextValue((bool) $container->call($is))
        );
    }

    public function getCacheKey(AbstractContext $context): string
    {
        return $context::class . '-' . $context->getCacheKey();
    }

    protected function cacheStrategy(AbstractContext $context): CacheMeStrategy
    {
        return $this->implementsService->check($context, UseCache::class)
            ? CacheMeStrategy::MemoryAndRepository
            : CacheMeStrategy::Memory;
    }

    protected function getTags(AbstractContext $context): array
    {
        $tags = [self::TAG];

        if ($this->implementsService->check($context, UseCacheWithTags::class) === false) {
            return $tags;
        }

        /** @var UseCacheWithTags $context */
        return array_merge($context->tags(), $tags);
    }
}
