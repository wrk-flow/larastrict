<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Config\Contracts;

use Closure;

final readonly class AppConfigContractGetVersionExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public string $return,
        public ?Closure $hook = null,
    ) {
    }
}
