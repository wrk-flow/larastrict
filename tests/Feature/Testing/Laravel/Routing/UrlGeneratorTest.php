<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Routing;

use LaraStrict\Testing\Laravel\Routing\UrlGenerator;
use PHPUnit\Framework\TestCase;

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
        $this->assertEquals(expected: 'http://localhost/current', actual: $this->urlGenerator->current());
    }

    public function testPrevious(): void
    {
        $this->assertEquals(
            expected: 'http://localhost/previous-fallback',
            actual: $this->urlGenerator->previous(),
        );
    }

    public function testPreviousFallbackEmptyString(): void
    {
        $this->assertEquals(expected: 'http://localhost/previous', actual: $this->urlGenerator->previous(''));
    }

    public function testPreviousFallbackCustom(): void
    {
        $this->assertEquals(
            expected: 'http://localhost/previous-fallback',
            actual: $this->urlGenerator->previous('s'),
        );
    }

    // test to function
    public function testTo(): void
    {
        $this->assertEquals(expected: 'http://localhost/path', actual: $this->urlGenerator->to('path'));
    }

    // test to function with extra parameters
    public function testToWithExtraParameters(): void
    {
        $this->assertEquals(
            expected: 'http://localhost/path?foo=bar',
            actual: $this->urlGenerator->to('path', [
                'foo' => 'bar',
            ]),
        );
    }

    // test to function with extra parameters and secure=true
    public function testToWithExtraParametersAndSecure(): void
    {
        $this->assertEquals(
            expected: 'https://localhost/path?foo=bar',
            actual: $this->urlGenerator->to('path', [
                'foo' => 'bar',
            ], true),
        );
    }

    // test secure function
    public function testSecure(): void
    {
        $this->assertEquals(expected: 'http://localhost/path', actual: $this->urlGenerator->secure('path'));
    }

    // test secure function with extra parameters
    public function testSecureWithExtraParameters(): void
    {
        $this->assertEquals(
            expected: 'http://localhost/path?foo=bar',
            actual: $this->urlGenerator->secure('path', [
                'foo' => 'bar',
            ]),
        );
    }

    // test asset function
    public function testAsset(): void
    {
        $this->assertEquals(expected: 'http://localhost/assets/path', actual: $this->urlGenerator->asset('path'));
    }

    // test asset function with secure=true
    public function testAssetWithSecure(): void
    {
        $this->assertEquals(
            expected: 'https://localhost/assets/path',
            actual: $this->urlGenerator->asset('path', true),
        );
    }

    // test route function
    public function testRoute(): void
    {
        $this->assertEquals(expected: 'http://localhost/route/name', actual: $this->urlGenerator->route('name'));
    }

    // test route function with extra parameters
    public function testRouteWithExtraParameters(): void
    {
        $this->assertEquals(
            expected: 'http://localhost/route/name?foo=bar',
            actual: $this->urlGenerator->route('name', [
                'foo' => 'bar',
            ]),
        );
    }

    // test route function with extra parameters and absolute=false
    public function testRouteWithExtraParametersAndAbsoluteFalse(): void
    {
        $this->assertEquals(
            expected: '/route/name?foo=bar',
            actual: $this->urlGenerator->route('name', [
                'foo' => 'bar',
            ], false),
        );
    }

    // test route function with absolute=false
    public function testRouteWithAbsoluteFalse(): void
    {
        $this->assertEquals(expected: '/route/name', actual: $this->urlGenerator->route('name', [], false));
    }

    // test action function
    public function testAction(): void
    {
        $this->assertEquals(
            expected: 'http://localhost/action/action',
            actual: $this->urlGenerator->action('action'),
        );
    }

    // test action function with extra parameters
    public function testActionWithExtraParameters(): void
    {
        $this->assertEquals(
            expected: 'http://localhost/action/action?foo=bar',
            actual: $this->urlGenerator->action('action', [
                'foo' => 'bar',
            ]),
        );
    }

    // test action function with extra parameters and absolute=false
    public function testActionWithExtraParametersAndAbsoluteFalse(): void
    {
        $this->assertEquals(
            expected: '/action/action?foo=bar',
            actual: $this->urlGenerator->action('action', [
                'foo' => 'bar',
            ], false),
        );
    }

    // test action function with absolute=false
    public function testActionWithAbsoluteFalse(): void
    {
        $this->assertEquals(expected: '/action/action', actual: $this->urlGenerator->action('action', [], false));
    }

    // test getRootControllerNamespace function
    public function testGetRootControllerNamespace(): void
    {
        $this->assertEquals(expected: 'App\Controllers', actual: $this->urlGenerator->getRootControllerNamespace());
    }

    // test setRootControllerNamespace function
    public function testSetRootControllerNamespace(): void
    {
        $this->urlGenerator->setRootControllerNamespace('App\Http\Controllers\New');
        $this->assertEquals(
            expected: 'App\Http\Controllers\New',
            actual: $this->urlGenerator->getRootControllerNamespace(),
        );
    }
}
