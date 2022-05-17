<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use LaraStrict\Http\Enums\HttpMessage;

class UpdatedResponse extends MessageResponse
{
    public function __construct()
    {
        parent::__construct(HttpMessage::Updated);
    }
}
