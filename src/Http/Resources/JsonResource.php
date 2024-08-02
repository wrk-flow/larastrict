<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use Illuminate\Container\Container as LaravelContainer;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection as SupportCollection;

/**
 * @template TResource
 *
 * @property TResource $resource
 */
abstract class JsonResource extends BaseJsonResource
{
    private ?Container $container = null;

    /**
     * When created in your code base, it non-null, but Laravel for "collection" uses null.
     *
     * @param TResource $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    final public function setContainer(Container $container): static
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param array<TResource>|Collection<array-key, TResource>|SupportCollection<array-key, TResource>|Paginator<TResource>|AbstractPaginator<TResource> $resource
     */
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

    final protected function getContainer(): Container
    {
        if ($this->container === null) {
            return LaravelContainer::getInstance();
        }

        return $this->container;
    }

    /**
     * Call toArray on the resource with given request. If the resource is a JsonResource or JsonResourceCollection,
     * container is set on the resource.
     *
     * @return array<string|int, mixed>
     */
    final protected function resourceArray(Request $request, BaseJsonResource $resource): array
    {
        if ($resource instanceof self || $resource instanceof JsonResourceCollection) {
            $resource->setContainer($this->getContainer());
        }

        return (array) $resource->toArray($request);
    }

    /**
     * @template TInstance of object
     *
     * @param class-string<TInstance> $class
     * @param array<string, mixed>    $parameters
     *
     * @return TInstance
     */
    final protected function instance(string $class, array $parameters = []): object
    {
        return $this
            ->getContainer()
            ->make(abstract: $class, parameters: $parameters);
    }
}
