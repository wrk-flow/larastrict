<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractIsContext;
use LaraStrict\Context\Values\BoolContextValue;

final class ContextServiceContractIsExpectation
{
    /**
     * @param Closure(AbstractIsContext, Closure, self):void|null $hook
     */
    public function __construct(
        public readonly BoolContextValue $return,
        public readonly AbstractIsContext $context,
        public readonly Closure $is,
        public readonly ?Closure $hook = null,
    ) {
    }
}
