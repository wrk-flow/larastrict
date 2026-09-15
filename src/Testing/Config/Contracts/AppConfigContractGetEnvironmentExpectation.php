<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Config\Contracts;

use Closure;
use LaraStrict\Enums\EnvironmentType;

final readonly class AppConfigContractGetEnvironmentExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public EnvironmentType|string $return,
        public ?Closure $hook = null,
    ) {
    }
}
