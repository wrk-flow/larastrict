<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JsonResourceCollection extends AnonymousResourceCollection
{
    private ?Container $container = null;

    public function setContainer(?Container $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return array<array-key, mixed>
     */
    public function toArray($request)
    {
        $collection = $this->collection;
        assert($collection !== null);

        return $collection->map(function (mixed $resource) use ($request) {
            assert($resource instanceof JsonResource);

            if ($this->container instanceof Container) {
                $resource->setContainer($this->container);
            }

            return $resource->toArray($request);
        })->all();
    }
}
