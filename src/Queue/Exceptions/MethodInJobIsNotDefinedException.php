<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Exceptions;

use RuntimeException;
use Throwable;

final class MethodInJobIsNotDefinedException extends RuntimeException
{
    /**
     * @param class-string $jobClass
     */
    public function __construct(string $method, string $jobClass, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf(
            'Given job <%s> does not contain desired method <%s>',
            $jobClass,
            $method
        ), $code, $previous);
    }
}
