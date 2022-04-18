<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Enums;

enum CacheMeStrategy: int
{
    case MemoryAndRepository = 0;
    case Memory = 1;
    case Repository = 2;
}
