<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Illuminate\Http\RedirectResponse;

final readonly class ResponseFactoryRedirectToExpectation
{
    /**
     * @param Closure(mixed, mixed, mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public RedirectResponse $return,
        public mixed $path,
        public mixed $status = 302,
        public mixed $headers = [],
        public mixed $secure = null,
        public ?Closure $hook = null,
    ) {
    }
}
