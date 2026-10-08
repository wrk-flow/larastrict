<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractContext;

final readonly class ContextServiceContractDeleteExpectation
{
    /**
     * @param Closure(AbstractContext, self):void|null $hook
     */
    public function __construct(
        public AbstractContext $context,
        public ?Closure $hook = null,
    ) {
    }
}
