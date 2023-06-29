<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use Illuminate\Container\Container as LaravelContainer;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;

abstract class JsonResource extends BaseJsonResource
{
    private ?Container $container = null;

    public function setContainer(Container $container): self
    {
        $this->container = $container;

        return $this;
    }

    public static function collection($resource): JsonResourceCollection
    {
        return tap(
            new JsonResourceCollection($resource, static::class),
            static function (JsonResourceCollection $collection) {
                // preserveKeys was added Laravel v9.45.0
                if (property_exists($collection, 'preserveKeys')
                    && property_exists(static::class, 'preserveKeys')) {
                    $collection->preserveKeys = (new static(null))->preserveKeys === true;
                }
            }
        );
    }

    protected function getContainer(): Container
    {
        if ($this->container === null) {
            return LaravelContainer::getInstance();
        }

        return $this->container;
    }

    /**
     * @template TInstance of object
     *
     * @param class-string<TInstance> $class
     * @param array<string, mixed>    $parameters
     *
     * @return TInstance
     */
    protected function instance(string $class, array $parameters = []): object
    {
        return $this
            ->getContainer()
            ->make(abstract: $class, parameters: $parameters);
    }
}
