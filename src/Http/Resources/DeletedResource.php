<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use LaraStrict\Http\Enums\HttpMessage;

class DeletedResource extends MessageResource
{
    public function __construct()
    {
        parent::__construct(HttpMessage::Deleted);
    }
}
