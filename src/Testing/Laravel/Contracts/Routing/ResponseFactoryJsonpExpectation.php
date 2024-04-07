<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Illuminate\Http\JsonResponse;

final class ResponseFactoryJsonpExpectation
{
    /**
     * @param Closure(mixed, mixed, mixed, array, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly JsonResponse $return,
        public readonly mixed $callback,
        public readonly mixed $data = [],
        public readonly mixed $status = 200,
        public readonly array $headers = [],
        public readonly mixed $options = 0,
        public readonly ?Closure $hook = null,
    ) {
    }
}
