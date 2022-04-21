<?php

declare(strict_types=1);

namespace LaraStrict\Context\Contexts;

use LaraStrict\Context\Contracts\ContextValueContract;
use LaraStrict\Context\Services\ContextEventsService;
use LaraStrict\Context\Services\ContextService;

/**
 * Context allows us to access data across multiple services / actions without loading data again using dependency
 * injection and "memory" context state manager.
 */
abstract class AbstractContext
{
    /**
     * In minutes
     */
    public function getCacheTtl(): int
    {
        return 3600;
    }

    abstract public function get(ContextService $contextService): ContextValueContract;

    abstract public function getCacheKey(): string;

    public static function boot(ContextEventsService $contextService): void
    {
    }
}
