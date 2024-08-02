<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;
use LaraStrict\Http\Resources\JsonResource;

/**
 * @extends JsonResource<BaseJsonResource>
 */
class ResourceArrayResource extends JsonResource
{
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
