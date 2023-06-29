<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

class PreserveKeysJsonResource extends MessageJsonResource
{
    public bool $preserveKeys = true;

    // TODO: Remove array when Laravel fixes its own implementation.
    public function __construct(string|null|array $resource)
    {
        parent::__construct(is_array($resource) ? null : $resource);
    }
}
