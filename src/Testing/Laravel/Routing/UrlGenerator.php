<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Routing;

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
        return $this->createUrl(path: 'route/' . $name, parameters: $parameters, absolute: $absolute);
    }

    public function action($action, $parameters = [], $absolute = true): string
    {
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

    protected function createUrl(
        string $path,
        array $parameters = [],
        mixed $secure = null,
        bool $absolute = true
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
