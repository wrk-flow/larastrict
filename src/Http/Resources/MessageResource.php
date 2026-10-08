<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use LaraStrict\Http\Enums\HttpMessage;

/**
 * @extends JsonResource<HttpMessage|string>
 */
class MessageResource extends JsonResource
{
    public static $wrap;

    /**
     * @return array<array-key, mixed>
     */
    public function toArray($request)
    {
        return [
            'message' => is_string($this->resource) ? $this->resource : $this->resource->value,
        ];
    }
}
