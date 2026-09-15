<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Illuminate\Http\JsonResponse;

final readonly class ResponseFactoryJsonExpectation
{
    /**
     * @param Closure(mixed, mixed, array<array-key, mixed>, mixed, self):void|null $hook
     * @param array<array-key, mixed> $headers
     */
    public function __construct(
        public JsonResponse $return,
        public mixed $data = [],
        public mixed $status = 200,
        public array $headers = [],
        public mixed $options = 0,
        public ?Closure $hook = null,
    ) {
    }
}
