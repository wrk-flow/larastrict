<?php

declare(strict_types=1);

namespace LaraStrict\Context\Services;

use Illuminate\Contracts\Container\Container;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contracts\ContextValueContract;

class ContextCallService
{
    public function __construct(private readonly Container $container)
    {
    }

    public function createState(AbstractContext $context, callable $createState): ContextValueContract
    {
        return $this->container->call($createState);
    }
}
