<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Illuminate\Http\RedirectResponse;

final class ResponseFactoryRedirectGuestExpectation
{
    /**
     * @param Closure(mixed, mixed, mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly RedirectResponse $return,
        public readonly mixed $path,
        public readonly mixed $status = 302,
        public readonly mixed $headers = [],
        public readonly mixed $secure = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
