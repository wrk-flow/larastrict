<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

use LaraStrict\Http\Resources\JsonResource;

/**
 * @property TestEntity $resource
 */
class LaraStrictResource extends JsonResource
{
    public function __construct(?TestEntity $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'test' => $this->resource->value,
            'instance' => $this->instance(TestAction::class)->execute(),
        ];
    }
}
