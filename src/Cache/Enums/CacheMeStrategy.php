<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Enums;

enum CacheMeStrategy: string
{
    /**
     * Will not store the value to cache.
     */
    case None = 'none';

    case MemoryAndRepository = 'memory_repository';
    case Memory = 'memory';
    case Repository = 'repository';
}
