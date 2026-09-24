---
title: Cache
---

The goal of this service is to add another memory cache layer (in PHP processes) when accessing the final Laravel cache repository (like Redis).

With this you will not hit Redis multiple times in a single request. Memory is cleared between each job or after the request is executed

## Usage

`CacheMeService` stores a value under a key. Inject `CacheMeServiceContract` when a service needs cache access. The default strategy checks the in-memory array store first, then the application's default Laravel cache store. On a cache miss, it calls the supplied closure and stores a non-null result. A value found in the repository is also copied into memory for later reads.

```php
use LaraStrict\Cache\Contracts\CacheMeServiceContract;

$value = $cache->get(
    key: 'product-' . $productId,
    getValue: fn () => $loadProduct($productId),
    seconds: 300,
);
```

`set()` stores a value. `delete()` removes one key. `flush()` clears the selected stores or tags. Use `observeAndFlush()` to clear tags when a model is created, updated, deleted, or restored.

## Storage strategy

| Strategy | Stores used |
| --- | --- |
| `MemoryAndRepository` | In-memory array and default Laravel cache; this is the default. |
| `Memory` | In-memory array only. |
| `Repository` | Default Laravel cache only. |
| `None` | No cache. `get()` calls the closure each time. |

Tags require a default cache store that supports Laravel cache tags. The service clears its in-memory store before and after queue jobs so a worker does not reuse values from another job. `flush()` without tags clears each selected store. Take care when the default store is shared with other application data.

## Cache debug logs

Cache operation logs are off by default. Set `LARASTRICT_CACHE_LOGGING=true` in the application's environment to emit debug logs for store, delete, and flush operations. `LoggingConfig::isCacheLoggingEnabled()` reads the setting from `log.cache_logging`. If Laravel configuration is cached, rebuild it after changing the environment value.

The logs include keys, tags, strategy, duration, or store classes as applicable. The `get()` and `set()` methods also accept `log: false` to suppress an individual store log. This setting does not change cache behavior or unrelated warning logs. The application's log level must allow debug messages.

See [Context](./context.md) for a typed way to share cached values across services.
