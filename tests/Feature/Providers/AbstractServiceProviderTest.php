<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers;

use Illuminate\Routing\Route;
use LaraStrict\Testing\Laravel\TestingServiceProvider;
use LaraStrict\Testing\Providers\Concerns\AssertProviderRegistersRoutes;
use Mockery\MockInterface;
use Psr\Log\LoggerInterface;
use Tests\LaraStrict\Feature\Providers\WithAll\WithAllServiceProvider;
use Tests\LaraStrict\Feature\Providers\WithApi\WithApiServiceProvider;
use Tests\LaraStrict\Feature\Providers\WithBoth\WithBothServiceProvider;
use Tests\LaraStrict\Feature\Providers\WithCustom\WithCustomServiceProvider;
use Tests\LaraStrict\Feature\Providers\WithVersionedApi\WithVersionedApiServiceProvider;
use Tests\LaraStrict\Feature\Providers\WithWeb\WithWebServiceProvider;
use Tests\LaraStrict\Feature\TestCase;

/**
 * Expects that name of folder is used as prefix and directory prefixs.
 */
class AbstractServiceProviderTest extends TestCase
{
    use AssertProviderRegistersRoutes;

    private MockInterface $loggerMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loggerMock = $this->mock(LoggerInterface::class);
    }

    public function testBootWithWebOnly(): void
    {
        $this->assertRoutes($this->app, WithWebServiceProvider::class, [
            'GET' => ['with-webs/3-url-web'],
        ]);
    }

    public function testWithoutInterface(): void
    {
        $this->assertRoutes($this->app, TestingServiceProvider::class, []);
    }

    public function testWithoutAnyUrl(): void
    {
        $this->loggerMock->shouldReceive('warning')
            ->once()
            ->withArgs(function (string $message, array $context) {
                $this->assertEquals('No routes have been loaded for <providers> service', $message);
                $this->assertArrayHasKey('dir', $context);
                $this->assertArrayHasKey('service', $context);
                $this->assertStringContainsString('tests/Feature/Providers', $context['dir']);
                $this->assertEquals(RoutableWithNoFilesServiceProvider::class, $context['service']);

                return true;
            });
        $this->assertRoutes($this->app, RoutableWithNoFilesServiceProvider::class, []);
    }

    public function testWithApiAndWeb(): void
    {
        $this->assertRoutes($this->app, WithBothServiceProvider::class, [
            'GET' => ['api/with-boths/2-url-api', 'with-boths/2-url-web'],
        ]);
    }

    public function testWithApiOnly(): void
    {
        $this->assertRoutes($this->app, WithApiServiceProvider::class, [
            'GET' => ['api/with-apis/1-api'],
        ]);
    }

    public function testWithVersionedApiOnly(): void
    {
        $this->assertRoutes($this->app, WithVersionedApiServiceProvider::class, [
            'GET' => ['api/v1/test/1-api', 'api/v2/test/2-api'],
        ]);
    }

    public function testWithCustomOnly(): void
    {
        $this->assertRoutes($this->app, WithCustomServiceProvider::class, [
            'GET' => [
                'with-customs/1-admin' => function (Route $route) {
                    $this->assertEquals(['admin'], $route->gatherMiddleware());
                },
                'dev/with-customs/1-dev' => function (Route $route) {
                    $this->assertEquals([], $route->gatherMiddleware());
                },
                'custom-route/with-customs/1-custom' => function (Route $route) {
                    $this->assertEquals([], $route->gatherMiddleware());
                },
            ],
        ]);
    }

    public function testWithAll(): void
    {
        $this->assertRoutes($this->app, WithAllServiceProvider::class, [
            'GET' => [
                'api/with-alls/2-url-api' => function (Route $route) {
                    $this->assertEquals(['api'], $route->gatherMiddleware());
                },
                'with-alls/2-url-web' => function (Route $route) {
                    $this->assertEquals(['web'], $route->gatherMiddleware());
                },
                'with-alls/1-admin' => function (Route $route) {
                    $this->assertEquals(['admin'], $route->gatherMiddleware());
                },
                'dev/with-alls/1-dev' => function (Route $route) {
                    $this->assertEquals([], $route->gatherMiddleware());
                },
                'custom-route/with-alls/2-custom' => function (Route $route) {
                    $this->assertEquals([], $route->gatherMiddleware());
                },
            ],
        ]);
    }
}
