<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Routing;

use DateInterval;
use DateTimeInterface;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;

class UrlGenerator implements UrlGeneratorContract
{
    private string $controllerNamespace = 'App\\Controllers';

    public function current(): string
    {
        return 'http://localhost/current';
    }

    public function previous($fallback = false): string
    {
        return 'http://localhost/previous' . ($fallback !== '' ? '-fallback' : '');
    }

    public function to($path, $extra = [], $secure = null): string
    {
        assert(is_array($extra));
        return $this->createUrl(path: $path, parameters: $extra, secure: $secure);
    }

    public function secure($path, $parameters = []): string
    {
        return $this->to(path: $path, extra: $parameters);
    }

    public function asset($path, $secure = null): string
    {
        return $this->to(path: 'assets/' . $path, secure: $secure);
    }

    public function route($name, $parameters = [], $absolute = true): string
    {
        assert(is_array($parameters));
        return $this->createUrl(path: 'route/' . $name, parameters: $parameters, absolute: $absolute);
    }

    /**
     * @todo Remove when dropping support for Laravel 10
     * Create a signed route URL for a named route.
     *
     * @param  string  $name
     * @param DateTimeInterface|DateInterval|int|null $expiration
     * @param  bool  $absolute
     * @return string
     */
    public function signedRoute($name, mixed $parameters = [], $expiration = null, $absolute = true)
    {
        assert(is_array($parameters));
        return $this->createUrl(path: 'signed-route/' . $name, parameters: $parameters, absolute: $absolute);
    }

    /**
     * @todo Remove when dropping support for Laravel 10
     * Create a temporary signed route URL for a named route.
     *
     * @param  string  $name
     * @param DateTimeInterface|DateInterval|int $expiration
     * @param  array  $parameters
     * @param  bool  $absolute
     *
     * @return string
     */
    public function temporarySignedRoute($name, $expiration, $parameters = [], $absolute = true)
    {
        assert(is_array($parameters));
        return $this->createUrl(path: 'temporary-signed-route/' . $name, parameters: $parameters, absolute: $absolute);
    }

    public function action($action, $parameters = [], $absolute = true): string
    {
        assert(is_array($parameters));
        $actionString = is_array($action) ? implode('-', $action) : $action;

        return $this->createUrl(path: 'action/' . $actionString, parameters: $parameters, absolute: $absolute);
    }

    public function getRootControllerNamespace(): string
    {
        return $this->controllerNamespace;
    }

    public function setRootControllerNamespace($rootNamespace): self
    {
        $this->controllerNamespace = $rootNamespace;

        return $this;
    }

    private function createUrl(
        string $path,
        array $parameters = [],
        mixed $secure = null,
        bool $absolute = true,
    ): string {
        $paramsString = $parameters === []
            ? ''
            : ('?' . http_build_query($parameters));
        $fullPath = '/' . $path . $paramsString;

        if ($absolute === false) {
            return $fullPath;
        }

        if ($secure === true) {
            return 'https://localhost' . $fullPath;
        }

        return 'http://localhost/' . $path . $paramsString;
    }
}
