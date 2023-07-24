<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Providers\Concerns;

use LaraStrict\Testing\Providers\Concerns\AssertProviderPolicies;
use Tests\LaraStrict\Feature\TestCase;

class AssertProviderPoliciesTest extends TestCase
{
    use AssertProviderPolicies;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app()
            ->register(ProviderPolicyServiceProvider::class);
    }

    public function testAssertPolicies(): void
    {
        $this->assertPolicies($this->app(), [
            TestPolicy::class => TestPolicy::class,
            MyOtherPolicyContract::class => MyOtherPolicy::class,
        ]);
    }

    public function testAssertPolicyWithExtendCheck(): void
    {
        $this->assertPolicy(
            application: $this->app(),
            policy: TestPolicy::class,
            expectedPolicyClass: TestPolicy::class,
            expectToExtendClass: MyOtherPolicy::class
        );
        $this->assertPolicy(
            application: $this->app(),
            policy: MyOtherPolicyContract::class,
            expectedPolicyClass: MyOtherPolicy::class,
            expectToExtendClass: null
        );
    }
}
