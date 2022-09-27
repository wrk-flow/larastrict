<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

interface RegisterNamedCustomRouteActionContract extends RegisterCustomRouteActionContract
{
    public function getFileSuffix(): string;
}
