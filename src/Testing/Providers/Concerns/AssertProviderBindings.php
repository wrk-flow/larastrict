<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Providers\Concerns;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\Assert;

trait AssertProviderBindings
{
    /**
     * @param array<string, class-string>   $expectedMap
     * @param class-string<ServiceProvider>|null $registerServiceProvider
     */
    public function assertBindings(
        Application $application,
        array $expectedMap,
        ?string $registerServiceProvider = null
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
