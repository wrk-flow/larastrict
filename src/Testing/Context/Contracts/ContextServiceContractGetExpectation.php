<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contracts\ContextValueContract;

final class ContextServiceContractGetExpectation
{
    /**
     * @param Closure(AbstractContext, Closure, self):void|null $hook
     */
    public function __construct(
        public readonly ContextValueContract $return,
        public readonly AbstractContext $context,
        public readonly Closure $createState,
        public readonly ?Closure $hook = null,
    ) {
    }
}
