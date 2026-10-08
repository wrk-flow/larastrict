<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contracts\ContextValueContract;

final readonly class ContextServiceContractSetWithoutCacheExpectation
{
    /**
     * @param Closure(AbstractContext, ContextValueContract, self):void|null $hook
     */
    public function __construct(
        public AbstractContext $context,
        public ContextValueContract $value,
        public ?Closure $hook = null,
    ) {
    }
}
