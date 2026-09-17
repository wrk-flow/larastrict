<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractContext;

final readonly class ContextServiceContractGetCacheKeyExpectation
{
    /**
     * @param Closure(AbstractContext, self):void|null $hook
     */
    public function __construct(
        public string $return,
        public AbstractContext $context,
        public ?Closure $hook = null,
    ) {
    }
}
