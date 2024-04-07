<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Illuminate\Http\Resources\Json\JsonResource;
use Tests\LaraStrict\Feature\Database\Models\TestModel;

/**
 * @property TestModel $resource
 */
class ModelResource extends JsonResource
{
    public function __construct(?TestModel $resource)
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
