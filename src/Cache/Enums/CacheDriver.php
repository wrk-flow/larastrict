<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Enums;

enum CacheDriver: string
{
    case Array = 'array';
    case Apc = 'apc';
    case File = 'file';
    case Memcached = 'memcached';
    case null = 'null';
    case Redis = 'redis';
    case Database = 'database';
    case Dynamodb = 'dynamodb';
}
