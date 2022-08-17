<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Http\Enums\HttpMessage;

/**
 * @property HttpMessage|string $resource
 */
class MessageResource extends JsonResource
{
    public static $wrap = null;

    public function __construct(HttpMessage|string|null $resource)
    {
        parent::__construct($resource);
    }

    /**
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => is_string($this->resource) ? $this->resource : $this->resource->value,
        ];
    }
}
