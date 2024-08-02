<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

use LaraStrict\Http\Resources\JsonResource;

/**
 * @extends JsonResource<TestEntity>
 */
class LaraStrictResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'test' => $this->resource->value,
            'instance' => $this->instance(TestAction::class)->execute(),
        ];
    }
}
