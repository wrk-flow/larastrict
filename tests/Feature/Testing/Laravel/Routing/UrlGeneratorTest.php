<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Routing;

use LaraStrict\Testing\Laravel\Routing\UrlGenerator;
use PHPUnit\Framework\TestCase;

enum RouteName: string
{
    case Home = 'home';
}

class UrlGeneratorTest extends TestCase
{
    private UrlGenerator $urlGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->urlGenerator = new UrlGenerator();
    }

    public function testCurrent(): void
    {
        $this->assertEquals('http://localhost/current', $this->urlGenerator->current());
    }

    public function testPrevious(): void
    {
        $this->assertEquals(
            'http://localhost/previous-fallback',
            $this->urlGenerator->previous(),
        );
    }

    public function testPreviousFallbackEmptyString(): void
    {
        $this->assertEquals('http://localhost/previous', $this->urlGenerator->previous(''));
    }

    public function testPreviousFallbackCustom(): void
    {
        $this->assertEquals(
            'http://localhost/previous-fallback',
            $this->urlGenerator->previous('s'),
        );
    }

    // test to function
    public function testTo(): void
    {
        $this->assertEquals('http://localhost/path', $this->urlGenerator->to('path'));
    }

    // test to function with extra parameters
    public function testToWithExtraParameters(): void
    {
        $this->assertEquals(
            'http://localhost/path?foo=bar',
            $this->urlGenerator->to('path', [
                'foo' => 'bar',
            ]),
        );
    }

    // test to function with extra parameters and secure=true
    public function testToWithExtraParametersAndSecure(): void
    {
        $this->assertEquals(
            'https://localhost/path?foo=bar',
            $this->urlGenerator->to('path', [
                'foo' => 'bar',
            ], true),
        );
    }

    // test secure function
    public function testSecure(): void
    {
        $this->assertEquals('http://localhost/path', $this->urlGenerator->secure('path'));
    }

    // test secure function with extra parameters
    public function testSecureWithExtraParameters(): void
    {
        $this->assertEquals(
            'http://localhost/path?foo=bar',
            $this->urlGenerator->secure('path', [
                'foo' => 'bar',
            ]),
        );
    }

    // test asset function
    public function testAsset(): void
    {
        $this->assertEquals('http://localhost/assets/path', $this->urlGenerator->asset('path'));
    }

    // test asset function with secure=true
    public function testAssetWithSecure(): void
    {
        $this->assertEquals(
            'https://localhost/assets/path',
            $this->urlGenerator->asset('path', true),
        );
    }

    // test route function
    public function testRoute(): void
    {
        $this->assertEquals('http://localhost/route/name', $this->urlGenerator->route('name'));
    }

    public function testRouteWithStringBackedEnum(): void
    {
        $this->assertEquals('http://localhost/route/home', $this->urlGenerator->route(RouteName::Home));
    }

    // test route function with extra parameters
    public function testRouteWithExtraParameters(): void
    {
        $this->assertEquals(
            'http://localhost/route/name?foo=bar',
            $this->urlGenerator->route('name', [
                'foo' => 'bar',
            ]),
        );
    }

    // test route function with extra parameters and absolute=false
    public function testRouteWithExtraParametersAndAbsoluteFalse(): void
    {
        $this->assertEquals(
            '/route/name?foo=bar',
            $this->urlGenerator->route('name', [
                'foo' => 'bar',
            ], false),
        );
    }

    // test route function with absolute=false
    public function testRouteWithAbsoluteFalse(): void
    {
        $this->assertEquals('/route/name', $this->urlGenerator->route('name', [], false));
    }

    public function testQuery(): void
    {
        $this->assertEquals(
            'https://localhost/path?existing=replaced&query=value&extra=value',
            $this->urlGenerator->query(
                'path?existing=value',
                [
                    'existing' => 'replaced',
                    'query' => 'value',
                ],
                [
                    'extra' => 'value',
                ],
                true,
            ),
        );
    }

    // test action function
    public function testAction(): void
    {
        $this->assertEquals(
            'http://localhost/action/action',
            $this->urlGenerator->action('action'),
        );
    }

    // test action function with extra parameters
    public function testActionWithExtraParameters(): void
    {
        $this->assertEquals(
            'http://localhost/action/action?foo=bar',
            $this->urlGenerator->action('action', [
                'foo' => 'bar',
            ]),
        );
    }

    // test action function with extra parameters and absolute=false
    public function testActionWithExtraParametersAndAbsoluteFalse(): void
    {
        $this->assertEquals(
            '/action/action?foo=bar',
            $this->urlGenerator->action('action', [
                'foo' => 'bar',
            ], false),
        );
    }

    // test action function with absolute=false
    public function testActionWithAbsoluteFalse(): void
    {
        $this->assertEquals('/action/action', $this->urlGenerator->action('action', [], false));
    }

    // test getRootControllerNamespace function
    public function testGetRootControllerNamespace(): void
    {
        $this->assertEquals('App\Controllers', $this->urlGenerator->getRootControllerNamespace());
    }

    // test setRootControllerNamespace function
    public function testSetRootControllerNamespace(): void
    {
        $this->urlGenerator->setRootControllerNamespace('App\Http\Controllers\New');
        $this->assertEquals(
            'App\Http\Controllers\New',
            $this->urlGenerator->getRootControllerNamespace(),
        );
    }
}
