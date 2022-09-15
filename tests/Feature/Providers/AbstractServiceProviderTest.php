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
            'GET' => ['with_webs/3_url_web'],
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
            'GET' => ['api/with_boths/2_url_api', 'with_boths/2_url_web'],
        ]);
    }

    public function testWithApiOnly(): void
    {
        $this->assertRoutes($this->app, WithApiServiceProvider::class, [
            'GET' => ['api/with_apis/1_api'],
        ]);
    }

    public function testWithVersionedApiOnly(): void
    {
        $this->assertRoutes($this->app, WithVersionedApiServiceProvider::class, [
            'GET' => ['api/v1/test/1_api', 'api/v2/test/2_api'],
        ]);
    }

    public function testWithCustomOnly(): void
    {
        $this->assertRoutes($this->app, WithCustomServiceProvider::class, [
            'GET' => [
                'with_customs/1_admin' => function (Route $route) {
                    $this->assertEquals(['admin'], $route->gatherMiddleware());
                },
                'dev/with_customs/1_dev' => function (Route $route) {
                    $this->assertEquals([], $route->gatherMiddleware());
                },
            ],
        ]);
    }

    public function testWithAll(): void
    {
        $this->assertRoutes($this->app, WithAllServiceProvider::class, [
            'GET' => [
                'api/with_alls/2_url_api' => function (Route $route) {
                    $this->assertEquals(['api'], $route->gatherMiddleware());
                },
                'with_alls/2_url_web' => function (Route $route) {
                    $this->assertEquals(['web'], $route->gatherMiddleware());
                },
                'with_alls/1_admin' => function (Route $route) {
                    $this->assertEquals(['admin'], $route->gatherMiddleware());
                },
                'dev/with_alls/1_dev' => function (Route $route) {
                    $this->assertEquals([], $route->gatherMiddleware());
                },
            ],
        ]);
    }
}
