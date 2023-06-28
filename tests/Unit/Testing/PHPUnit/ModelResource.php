<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Illuminate\Http\Resources\Json\JsonResource;
use Tests\LaraStrict\Feature\Database\Models\Test;

/**
 * @property Test $resource
 */
class ModelResource extends JsonResource
{
    public function __construct(?Test $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'test' => $this->resource->test,
        ];
    }
}
