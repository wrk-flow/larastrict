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

    public function toArray($request)
    {
        return $this->collection->map(function (JsonResource $resource) use ($request) {
            if ($this->container !== null) {
                $resource->setContainer($this->container);
            }

            return $resource->toArray($request);
        })->all();
    }
}
