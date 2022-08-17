<?php

declare(strict_types=1);

namespace LaraStrict\Health\Http\Controllers;

use LaraStrict\Http\Enums\HttpMessage;
use LaraStrict\Http\Resources\MessageResource;

class AliveController
{
    public function __invoke(): MessageResource
    {
        return new MessageResource(HttpMessage::Ok);
    }
}
