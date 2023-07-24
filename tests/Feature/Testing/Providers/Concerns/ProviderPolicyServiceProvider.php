<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Providers\Concerns;

use LaraStrict\Contracts\HasPolicies;
use LaraStrict\Providers\AbstractServiceProvider;

class ProviderPolicyServiceProvider extends AbstractServiceProvider implements HasPolicies
{
    public array $bindings = [
        MyOtherPolicyContract::class => MyOtherPolicy::class,
    ];

    public function policies(): array
    {
        return [
            TestPolicy::class => TestPolicy::class,
            MyOtherPolicyContract::class => MyOtherPolicy::class,
        ];
    }
}
