<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Http\Enums\HttpMessage;

/**
 * @property HttpMessage $resource
 */
class MessageResponse extends JsonResource
{
    public static $wrap = null;

    public function __construct(HttpMessage|null $resource)
    {
        parent::__construct($resource);
    }

    /**
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => $this->resource->value,
        ];
    }
}
