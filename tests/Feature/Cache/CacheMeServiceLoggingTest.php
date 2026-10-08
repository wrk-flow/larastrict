<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Cache;

use Illuminate\Contracts\Cache\Factory;
use LaraStrict\Cache\Enums\CacheMeStrategy;
use LaraStrict\Cache\Services\CacheMeService;
use LaraStrict\Log\Config\LoggingConfig;
use LaraStrict\Testing\Laravel\Logger as TestingLogger;
use Tests\LaraStrict\Feature\TestCase;

class CacheMeServiceLoggingTest extends TestCase
{
    public function testCacheDebugLogsAreDisabledByDefault(): void
    {
        $logger = new TestingLogger();

        $cache = $this->cacheService($logger);
        $cache->set('key', 'value', strategy: CacheMeStrategy::Memory);
        $cache->delete('key', strategy: CacheMeStrategy::Memory);
        $cache->flush(strategy: CacheMeStrategy::Memory);

        $this->assertSame([], $logger->debug);
    }

    public function testCacheDebugLogsCanBeEnabled(): void
    {
        $this->loggingConfig()
            ->setCacheLoggingEnabled(true);

        $logger = new TestingLogger();

        $cache = $this->cacheService($logger);
        $cache->set('key', 'value', strategy: CacheMeStrategy::Memory);
        $cache->delete('key', strategy: CacheMeStrategy::Memory);
        $cache->flush(strategy: CacheMeStrategy::Memory);

        $this->assertSame(
            ['Storing cache', 'Deleting cache', 'Flushing cache'],
            array_column($logger->debug, 0),
        );
    }

    public function testIndividualStoreLogCanBeDisabled(): void
    {
        $this->loggingConfig()
            ->setCacheLoggingEnabled(true);

        $logger = new TestingLogger();

        $this->cacheService($logger)
            ->set('key', 'value', strategy: CacheMeStrategy::Memory, log: false);

        $this->assertSame([], $logger->debug);
    }

    private function cacheService(TestingLogger $logger): CacheMeService
    {
        return new CacheMeService(
            $this->app()
                ->make(Factory::class),
            $logger,
            $this->app(),
            $this->loggingConfig(),
        );
    }

    private function loggingConfig(): LoggingConfig
    {
        return $this->app()
            ->make(LoggingConfig::class);
    }
}
