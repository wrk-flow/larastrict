<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Providers\Concerns;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Foundation\Application;
use PHPUnit\Framework\Assert;
use ReflectionClass;

trait AssertProviderPolicies
{
    /**
     * @param array<string, class-string<object>> $policyMap
     */
    protected function assertPolicies(Application $application, array $policyMap): void
    {
        $gate = $application->get(Gate::class);

        foreach ($policyMap as $key => $expectedClass) {
            $this->getPolicy($gate, $key, $expectedClass);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $expectedPolicyClass
     *
     * @return T
     */
    protected function assertPolicy(
        Application $application,
        string $policy,
        string $expectedPolicyClass,
        string|bool|null $expectToExtendClass = false,
    ): object {
        $gate = $application->get(Gate::class);

        $policyInstance = $this->getPolicy($gate, $policy, $expectedPolicyClass);

        if (is_bool($expectToExtendClass)) {
            return $policyInstance;
        }

        $reflection = new ReflectionClass($policyInstance);
        $parentClass = $reflection->getParentClass();

        if ($expectToExtendClass === null) {
            Assert::assertTrue(
                $parentClass === false,
                sprintf('Policy (%s) does should not extend any class', $policy),
            );
            return $policyInstance;
        }

        Assert::assertTrue($parentClass !== false, 'Policy does not extend any class');
        Assert::assertEquals(
            $expectToExtendClass,
            $parentClass->getName(),
            sprintf('Policy (%s)does not extend expected class', $policy),
        );

        return $policyInstance;
    }

    /**
     * @template TIn of object
     * @param class-string<TIn> $expectedPolicyClass
     *
     * @return TIn
     */
    private function getPolicy(Gate $gate, string $policy, string $expectedPolicyClass): object
    {
        $policy = $gate->getPolicyFor($policy);
        Assert::assertInstanceOf(
            $expectedPolicyClass,
            $policy,
            'Policy does not match expected class',
        );

        return $policy;
    }
}
