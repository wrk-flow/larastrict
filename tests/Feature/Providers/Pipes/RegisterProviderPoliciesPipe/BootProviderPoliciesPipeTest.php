<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\RegisterProviderPoliciesPipe;

use Illuminate\Contracts\Auth\Access\Gate;
use Tests\LaraStrict\Feature\TestCase;

class BootProviderPoliciesPipeTest extends TestCase
{
    public function test(): void
    {
        $this->app()
            ->register(PoliciesServiceProvider::class, true);

        /** @var Gate $gate */
        $gate = $this->app()
            ->make(Gate::class);

        $policy = $gate->getPolicyFor(Test::class);
        $this->assertInstanceOf(TestPolicy::class, $policy);
    }
}
