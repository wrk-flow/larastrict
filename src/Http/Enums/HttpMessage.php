<?php

declare(strict_types=1);

namespace LaraStrict\Http\Enums;

enum HttpMessage: string
{
    case Ok = 'ok';
    case Updated = 'updated';
    case Created = 'created';
    case Deleted = 'deleted';
}
