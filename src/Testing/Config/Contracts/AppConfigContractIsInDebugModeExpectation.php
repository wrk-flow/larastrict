<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Config\Contracts;

use Closure;

final class AppConfigContractIsInDebugModeExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
