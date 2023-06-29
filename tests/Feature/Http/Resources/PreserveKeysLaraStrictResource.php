<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

use LaraStrict\Http\Resources\MessageResource;

class PreserveKeysLaraStrictResource extends MessageResource
{
    public bool $preserveKeys = true;
}
