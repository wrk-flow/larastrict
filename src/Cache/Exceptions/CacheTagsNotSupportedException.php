<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Exceptions;

use Exception;
use Throwable;

class CacheTagsNotSupportedException extends Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $reason = 'You are trying to use cache with tags but your driver does not support it. Do not use tags or you driver that supports tags. Otherwise this would cause bugs like deleting queue.' . ($message === '' ? '' : sprintf(
            '. %s',
            $message,
        ));

        parent::__construct($reason, $code, $previous);
    }
}
