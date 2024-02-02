<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Constants;

/**
 * Stores in seconds
 */
final class CacheExpirations
{
    /**
     * minute in seconds
     */
    public const Minute = 60;

    /**
     * hour in seconds
     */
    public const Hour = 60 * self::Minute;

    /**
     * day in seconds
     */
    public const Day = 24 * self::Hour;

    /**
     * week in seconds
     */
    public const Week = 7 * self::Day;

    /**
     * average month in seconds
     */
    public const Month = 2_629_800;

    /**
     * average year in seconds
     */
    public const Year = 31_557_600;

    /**
     * Fixed value
     *
     * @deprecated
     */
    public const Long = self::Month;

    /**
     * @deprecated
     */
    public const HalfDay = 12 * self::Hour;
}
