<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Enums;

enum CacheMeStrategy: string
{
    case MemoryAndRepository = 'memory_repository';
    case Memory = 'memory';
    case Repository = 'repository';
}
