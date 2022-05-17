<?php

declare(strict_types=1);

namespace LaraStrict\Http\Enums;

enum HttpMessage: string
{
    case Updated = 'updated';
    case Created = 'created';
    case Deleted = 'deleted';
}
