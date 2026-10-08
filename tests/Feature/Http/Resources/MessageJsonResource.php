<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $resource
 */
class MessageJsonResource extends JsonResource
{
    public static $wrap;

    public function __construct(string|null $resource)
    {
        parent::__construct($resource);
    }

    /**
     * @return array<array-key, mixed>
     */
    public function toArray($request)
    {
        return [
            'message' => $this->resource,
        ];
    }
}
