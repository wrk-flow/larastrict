<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Providers\Concerns;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use LaraStrict\Providers\AbstractServiceProvider;
use PHPUnit\Framework\Assert;

trait AssertProviderRegistersRoutes
{
    /**
     * Asserts correct that routes are correctly registered in correct prefix (pluralized)
     *
     * @param bool                                                         $onlyGiven Check if only given routes can be
     * @param array<string, array<string>|array<int, Closure(Route):void>> $expectUrlsByMethod
     * ['GET'=>['web/tests/my-api']]
     * @param class-string<AbstractServiceProvider>|null                        $registerServiceProvider
     * registered
     */
    public function assertRoutes(
        Application $application,
        array $expectUrlsByMethod,
        ?string $registerServiceProvider = null,
        bool $onlyGiven = false
    ): void {
        if ($registerServiceProvider !== null) {
            $application->register($registerServiceProvider, true);
        }

        /** @var Router $router */
        $router = $application->make(Router::class);

        $routes = $router->getRoutes();
        if ($expectUrlsByMethod === []) {
            Assert::assertTrue(true);
            return;
        }

        foreach ($expectUrlsByMethod as $method => $urls) {
            $registeredUrls = $routes->get($method);

            $expectedUrls = [];
            foreach ($urls as $index => $value) {
                $url = is_callable($value) ? $index : $value;
                $expectedUrls[] = $url;
            }

            if ($onlyGiven) {
                Assert::assertEquals($expectedUrls, array_keys($registeredUrls));
            }

            $errorMessage = 'Not found in: ' . implode(', ', array_keys($registeredUrls));

            foreach ($urls as $index => $value) {
                $url = is_callable($value) ? $index : $value;

                if ($onlyGiven === false) {
                    Assert::assertArrayHasKey($url, $registeredUrls, $errorMessage);
                }

                if (is_callable($value)) {
                    $value($registeredUrls[$url]);
                }
            }
        }
    }
}
