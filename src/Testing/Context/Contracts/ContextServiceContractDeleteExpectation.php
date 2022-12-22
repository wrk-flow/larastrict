<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractContext;

final class ContextServiceContractDeleteExpectation
{
    /**
     * @param Closure(AbstractContext, self):void|null $hook
     */
    public function __construct(
        public readonly AbstractContext $context,
        public readonly ?Closure $hook = null,
    ) {
    }
}
