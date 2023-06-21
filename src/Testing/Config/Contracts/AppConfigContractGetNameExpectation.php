<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Config\Contracts;

use Closure;

final class AppConfigContractGetNameExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public readonly string $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
