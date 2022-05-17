<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

interface HasVersionedApiRoutes
{
    /**
     * Return api version you want to support. Automatically looks for
     * {Domain}/Http/routes/{domainPrefix}_api_v{version}.php file and uses a prefix api/v{version}.
     *
     * @return array<int>
     */
    public function apiVersions(): array;
}
