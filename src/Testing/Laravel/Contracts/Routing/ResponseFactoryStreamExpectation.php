<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ResponseFactoryStreamExpectation
{
    /**
     * @param Closure(mixed, mixed, array, self):void|null $hook
     */
    public function __construct(
        public readonly StreamedResponse $return,
        public readonly mixed $status = 200,
        public readonly array $headers = [],
        public readonly ?Closure $hook = null,
    ) {
    }
}
