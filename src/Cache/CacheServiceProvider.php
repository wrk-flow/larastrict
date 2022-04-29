<?php

declare(strict_types=1);

namespace LaraStrict\Cache;

use Illuminate\Queue\QueueManager;
use Illuminate\Support\ServiceProvider;
use LaraStrict\Cache\Commands\FlushCacheCommand;
use LaraStrict\Cache\Contracts\CacheMeServiceContract;
use LaraStrict\Cache\Enums\CacheMeStrategy;
use LaraStrict\Cache\Services\CacheMeService;

class CacheServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton(CacheMeService::class, CacheMeService::class);
        $this->app->singleton(CacheMeServiceContract::class, CacheMeService::class);

        if ($this->app->runningInConsole()) {
            $this->commands([FlushCacheCommand::class]);
        }
    }

    public function boot(): void
    {
        $this->clearMemoryCacheBeforeQueueJobs();
    }

    protected function clearMemoryCacheBeforeQueueJobs(): void
    {
        /** @var CacheMeServiceContract $cacheMe */
        $cacheMe = $this->app->make(CacheMeServiceContract::class);

        // After each job reset memory cache to prevent in-consistent data.
        $callback = function () use ($cacheMe): void {
            $cacheMe->flush(strategy: CacheMeStrategy::Memory);
        };

        /** @var QueueManager $queue */
        $queue = $this->app->make(QueueManager::class);
        $queue->before($callback);
        $queue->after($callback);
    }
}
