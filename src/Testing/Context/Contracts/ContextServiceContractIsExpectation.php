<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractIsContext;
use LaraStrict\Context\Values\BoolContextValue;

final readonly class ContextServiceContractIsExpectation
{
    /**
     * @param Closure(AbstractIsContext, Closure, self):void|null $hook
     */
    public function __construct(
        public BoolContextValue $return,
        public AbstractIsContext $context,
        public Closure $is,
        public ?Closure $hook = null,
    ) {
    }
}
