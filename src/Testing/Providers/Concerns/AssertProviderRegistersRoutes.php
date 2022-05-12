<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Providers\Concerns;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use LaraStrict\Providers\AbstractServiceProvider;
use PHPUnit\Framework\Assert;

trait AssertProviderRegistersRoutes
{
    /**
     * Asserts correct that routes are correctly registered in correct prefix (pluralized)
     *
     * @param class-string<AbstractServiceProvider> $registerServiceProvider
     * @param array<string, array<string>>          $expectUrlsByMethod ['GET'=>['web/tests/my-api']]
     */
    public function assertRoutes(
        Application $application,
        string $registerServiceProvider,
        array $expectUrlsByMethod
    ): void {
        $application->register($registerServiceProvider, true);

        /** @var Router $router */
        $router = $application->make(Router::class);

        $routes = $router->getRoutes();
        if ($expectUrlsByMethod === []) {
            Assert::assertTrue(true);
            return;
        }

        foreach ($expectUrlsByMethod as $method => $urls) {
            $registeredUrls = $routes->get($method);

            $errorMessage = 'Not found in: ' . implode(', ', array_keys($registeredUrls));

            foreach ($urls as $url) {
                Assert::assertArrayHasKey($url, $registeredUrls, $errorMessage);
            }
        }
    }
}
