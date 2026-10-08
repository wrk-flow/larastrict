---
title: Context
---

A context gives services a shared, typed value. Extend `AbstractContext` and implement `getCacheKey()` and `get()`. The context service builds a full key from the context class and your key. It stores values in memory by default.

```php
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contracts\ContextServiceContract;
use LaraStrict\Context\Contracts\ContextValueContract;

final class ProductContext extends AbstractContext
{
    public function __construct(private readonly int $productId)
    {
    }

    public function getCacheKey(): string
    {
        return (string) $this->productId;
    }

    public function get(ContextServiceContract $contextService): ContextValueContract
    {
        return $contextService->get($this, fn () => new ProductValue($this->productId));
    }
}
```

`ProductValue` must implement `ContextValueContract`. Implement `UseCache` on a context to store its value in both memory and the default Laravel cache. Implement `UseCacheWithTags` and return a list from `tags()` when related values need to be invalidated together. Override `getCacheTtl()` to change the cache duration in seconds.

Use `ContextServiceContract::set()` to replace a value, `setWithoutCache()` to write to memory only, and `delete()` to remove a key. `AbstractIsContext` supports a boolean context through its `is()` closure. `ContextEventsService` can set or clear context values in response to events and model changes.

Context storage uses [CacheMeService](./cache.md). Its cache debug logs use the same `LARASTRICT_CACHE_LOGGING` setting.
