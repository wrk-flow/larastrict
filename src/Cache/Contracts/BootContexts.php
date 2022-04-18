<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Contracts;

use LaraStrict\Context\Contexts\AbstractContext;

interface BootContexts
{
    /**
     * @return array<class-string<AbstractContext>>
     */
    public function contexts(): array;
}
