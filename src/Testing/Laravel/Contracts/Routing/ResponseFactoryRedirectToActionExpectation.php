<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Illuminate\Http\RedirectResponse;

final readonly class ResponseFactoryRedirectToActionExpectation
{
    /**
     * @param Closure(mixed, mixed, mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public RedirectResponse $return,
        public mixed $action,
        public mixed $parameters = [],
        public mixed $status = 302,
        public mixed $headers = [],
        public ?Closure $hook = null,
    ) {
    }
}
