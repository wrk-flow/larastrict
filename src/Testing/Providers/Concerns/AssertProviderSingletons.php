<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Providers\Concerns;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\Assert;

trait AssertProviderSingletons
{
    /**
     * @param array<class-string|string>   $expectedMap
     * @param class-string<ServiceProvider>|null $registerServiceProvider
     */
    public function assertSingletons(
        Application $application,
        array $expectedMap,
        ?string $registerServiceProvider = null,
    ): void {
        if ($registerServiceProvider !== null) {
            $application->register($registerServiceProvider);
        }

        foreach ($expectedMap as $binding) {
            $object = $application->make($binding);
            $singleton = $application->make($binding);

            Assert::assertSame($singleton, $object);
        }
    }
}
