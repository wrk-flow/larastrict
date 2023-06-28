<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Illuminate\Http\Resources\Json\JsonResource;
use Tests\LaraStrict\Feature\Http\Resources\TestEntity;

/**
 * @property TestEntity $resource
 */
class LaravelResource extends JsonResource
{
    public function __construct(?TestEntity $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'test' => $this->resource->value,
        ];
    }
}
