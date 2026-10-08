<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\RegisterProviderPoliciesPipe;

use LaraStrict\Contracts\HasPolicies;
use LaraStrict\Providers\AbstractServiceProvider;

class PoliciesServiceProvider extends AbstractServiceProvider implements HasPolicies
{
    public function policies(): array
    {
        return [
            TestEntity::class => TestPolicy::class,
        ];
    }
}
