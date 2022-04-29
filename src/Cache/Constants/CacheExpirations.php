<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Constants;

/**
 * Stores on minutes.
 */
class CacheExpirations
{
    /**
     * 720 minutes - 12 hours.
     *
     * @var int
     */
    final public const HalfDay = 720;

    /**
     * 1 days.
     *
     * @var int
     */
    final public const Long = 44640;
}
