<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contracts\ContextValueContract;

final readonly class ContextServiceContractGetExpectation
{
    /**
     * @param Closure(AbstractContext, Closure, self):void|null $hook
     * @param Closure(Closure $context):mixed                   $runCreateState should contain a closure that will
     *                                                          execute given $createState method with correct
     *                                                          parameters. The returned value will be asserted with
     *                                                          given $expectation->return value.
     */
    public function __construct(
        public ContextValueContract $return,
        public AbstractContext $context,
        public ?Closure $hook = null,
        public ?Closure $runCreateState = null,
    ) {
    }
}
