<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;
use LaraStrict\Http\Resources\JsonResource;

/**
 * @property BaseJsonResource $resource
 */
class ResourceArrayResource extends JsonResource
{
    public function __construct(?BaseJsonResource $resource)
    {
        parent::__construct($resource);
    }

    /**
     * @return array<string, array<array<string, mixed>>>
     */
    public function toArray($request)
    {
        return [
            'res' => $this->resourceArray($request, $this->resource),
        ];
    }
}
