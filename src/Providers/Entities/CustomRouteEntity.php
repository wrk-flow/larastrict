<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Entities;

class CustomRouteEntity
{
    public function __construct(
        public readonly string $path,
        public readonly string $serviceName,
        public readonly string $urlPrefix,
    ) {
    }
}
