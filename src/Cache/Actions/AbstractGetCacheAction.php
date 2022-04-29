<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Actions;

use LaraStrict\Cache\Services\CacheMeService;

/**
 * Implement public function execute(); that will return your cached value.
 */
abstract class AbstractGetCacheAction
{
    public function __construct(protected CacheMeService $cacheMeService)
    {
    }
}
