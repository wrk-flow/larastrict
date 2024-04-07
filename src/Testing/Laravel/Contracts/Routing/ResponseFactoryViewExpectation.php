<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Illuminate\Http\Response;

final class ResponseFactoryViewExpectation
{
    /**
     * @param Closure(mixed, mixed, mixed, array, self):void|null $hook
     */
    public function __construct(
        public readonly Response $return,
        public readonly mixed $view,
        public readonly mixed $data = [],
        public readonly mixed $status = 200,
        public readonly array $headers = [],
        public readonly ?Closure $hook = null,
    ) {
    }
}
