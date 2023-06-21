<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Config\Contracts;

use Closure;
use LaraStrict\Enums\EnvironmentType;

final class AppConfigContractGetEnvironmentExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public readonly EnvironmentType|string $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
