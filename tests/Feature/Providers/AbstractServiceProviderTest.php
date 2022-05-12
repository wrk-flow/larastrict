<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers;

use LaraStrict\Testing\Providers\Concerns\AssertProviderRegistersRoutes;
use Tests\LaraStrict\App\Providers\RoutableWithNoFilesServiceProvider;
use Tests\LaraStrict\App\Providers\TestingServiceProvider;
use Tests\LaraStrict\App\Providers\WithApi\WithApiServiceProvider;
use Tests\LaraStrict\App\Providers\WithBoth\WithBothServiceProvider;
use Tests\LaraStrict\App\Providers\WithWeb\WithWebServiceProvider;
use Tests\LaraStrict\Feature\TestCase;

/**
 * Expects that name of folder is used as prefix and directory prefixs.
 */
class AbstractServiceProviderTest extends TestCase
{
    use AssertProviderRegistersRoutes;

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
}
