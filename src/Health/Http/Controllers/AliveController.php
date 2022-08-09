<?php

declare(strict_types=1);

namespace LaraStrict\Health\Http\Controllers;

use LaraStrict\Http\Enums\HttpMessage;
use LaraStrict\Http\Resources\MessageResponse;

class AliveController
{
    public function __invoke(): MessageResponse
    {
        return new MessageResponse(HttpMessage::Ok);
    }
}
