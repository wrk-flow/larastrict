<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Config\Contracts;

use Closure;

final readonly class AppConfigContractGetNameExpectation
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
