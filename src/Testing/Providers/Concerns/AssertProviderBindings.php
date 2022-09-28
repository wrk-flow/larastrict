<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Providers\Concerns;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\Assert;

trait AssertProviderBindings
{
    /**
     * @param class-string<ServiceProvider> $registerServiceProvider
     * @param array<string, class-string>   $expectedMap
     */
    public function assertBindings(
        Application $application,
        ?string $registerServiceProvider,
        array $expectedMap
    ): void {
        if ($registerServiceProvider !== null) {
            $application->register($registerServiceProvider);
        }

        foreach ($expectedMap as $binding => $expectedClass) {
            $object = $application->make($binding);

            Assert::assertInstanceOf($expectedClass, $object);
        }
    }
}
