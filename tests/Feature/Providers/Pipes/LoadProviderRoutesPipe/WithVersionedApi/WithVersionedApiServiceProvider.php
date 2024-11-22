<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderRoutesPipe\WithVersionedApi;

use LaraStrict\Contracts\HasCustomPrefixRoutes;
use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Contracts\HasVersionedApiRoutes;
use LaraStrict\Providers\AbstractServiceProvider;

class WithVersionedApiServiceProvider extends AbstractServiceProvider implements HasRoutes, HasVersionedApiRoutes, HasCustomPrefixRoutes
{
    public function getRoutePrefix(string $generatedPrefix): string
    {
        return 'test';
    }

    public function apiVersions(): array
    {
        return [1, 1.1, 2];
    }
}
